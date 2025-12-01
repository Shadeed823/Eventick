<?php

namespace App\Http\Controllers\Seller;

use App\Constants\TicketStatus;
use App\Constants\NotificationType;
use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Ticket;
use App\Models\Notification;
use App\Traits\SendsNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    use SendsNotifications;
    public function index(Request $request)
    {
        $query = Bid::whereHas('ticket', function($query) {
            $query->where('seller_id', Auth::id());
        })->with(['ticket', 'buyer']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('ticket_id') && $request->ticket_id != '') {
            $query->where('ticket_id', $request->ticket_id);
        }

        // Apply sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('bid_time', 'asc');
                break;
            case 'highest':
                $query->orderBy('bid_amount', 'desc');
                break;
            case 'lowest':
                $query->orderBy('bid_amount', 'asc');
                break;
            default:
                $query->orderBy('bid_time', 'desc');
        }

        $bids = $query->get();
        $tickets = Ticket::where('seller_id', Auth::id())->get();

        return view('seller.bids.index', compact('bids', 'tickets'));
    }

    public function show(Ticket $ticket)
    {
        $bids = $ticket->bids()
            ->with('buyer')
            ->orderBy('bid_amount', 'desc')
            ->get();

        return view('seller.bids.show', compact('ticket', 'bids'));
    }

    public function accept(Bid $bid)
    {
        if ($bid->ticket->status !== 'Available') {
            return redirect()->back()->with('error', 'Ticket is not available for sale.');
        }
        if ($bid->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'This bid has already been processed.');
        }
        $bid->ticket->update([
            'status' => TicketStatus::SOLD,
            'buyer_id' => $bid->buyer_id,
            'price' => $bid->bid_amount,
        ]);
        $bid->update(['status' => 'accepted']);

        // Reject all other bids
        Bid::where('ticket_id', $bid->ticket_id)
            ->where('bid_id', '!=', $bid->bid_id)
            ->update(['status' => 'rejected']);

        $this->sendBidAcceptedNotification($bid);

        // Send notifications to other bidders (optional)
        $this->sendBidRejectedNotifications($bid->ticket_id, $bid->bid_id);

        return redirect()->back()
            ->with('success', 'Bid accepted successfully. Ticket sold to ' . $bid->buyer->name);
    }

    public function reject(Bid $bid)
    {
        $this->authorize('manage', $bid->ticket);
        if ($bid->status !== 'pending') {
            return redirect()->back()->with('error', 'This bid has already been processed.');
        }
        $bid->update(['status' => 'rejected']);

        // Send notification to the rejected bidder
        $this->sendBidRejectedNotification($bid);

        return redirect()->back()->with('success', 'Bid rejected successfully.');
    }

    public function endAuction(Ticket $ticket)
    {
        if ($ticket->selling_method !== 'Auction') {
            return redirect()->back()->with('error', 'Only auction tickets can be ended manually.');
        }
        if ($ticket->status !== 'Available') {
            return redirect()->back()
                ->with('error', 'Ticket is not available for auction ending.');
        }

        $highestBid = $ticket->bids()->orderBy('bid_amount', 'desc')->first();

        if ($highestBid) {
            // Update ticket and bid status
            $ticket->update([
                'status' => TicketStatus::SOLD,
                'buyer_id' => $highestBid->buyer_id,
                'price' => $highestBid->bid_amount,
            ]);
            $highestBid->update(['status' => 'accepted']);

            // Reject all other bids
            Bid::where('ticket_id', $ticket->ticket_id)
                ->where('bid_id', '!=', $highestBid->bid_id)
                ->update(['status' => 'rejected']);

            // Send notification to the winning buyer
            $this->sendAuctionWonNotification($highestBid);

            // Send notifications to other bidders
            $this->sendAuctionLostNotifications($ticket->ticket_id, $highestBid->bid_id);

            return redirect()->back()->with('success', 'Auction ended successfully. Ticket sold to highest bidder.');
        } else {
            $ticket->update(['status' => TicketStatus::EXPIRED]);
            return redirect()->back()
                ->with('info', 'Auction ended with no bids. Ticket marked as expired.');
        }
    }

    private function sendBidAcceptedNotification(Bid $bid)
    {
        Notification::create([
            'user_id' => $bid->buyer_id,
            'message' => "Congratulations! Your bid of " . number_format($bid->bid_amount, 2) . " SAR for '{$bid->ticket->event_name}' has been accepted. Please proceed with payment to complete your purchase.",
            'type' => NotificationType::BID_UPDATE,
            'status' => 'Unread',
            'created_at' => now(),
        ]);
    }

    private function sendBidRejectedNotification(Bid $bid)
    {
        Notification::create([
            'user_id' => $bid->buyer_id,
            'message' => "Your bid of " . number_format($bid->bid_amount, 2) . " SAR for '{$bid->ticket->event_name}' was not accepted. The seller has chosen another bidder.",
            'type' => NotificationType::BID_UPDATE,
            'status' => 'Unread',
            'created_at' => now(),
        ]);
    }

    private function sendBidRejectedNotifications($ticketId, $winningBidId)
    {
        $rejectedBids = Bid::where('ticket_id', $ticketId)
            ->where('bid_id', '!=', $winningBidId)
            ->where('status', 'rejected')
            ->with('ticket', 'buyer')
            ->get();
        foreach ($rejectedBids as $bid) {
            Notification::create([
                'user_id' => $bid->buyer_id,
                'message' => "Your bid for '{$bid->ticket->event_name}' was not accepted. The seller has chosen another bidder.",
                'type' => NotificationType::BID_UPDATE,
                'status' => 'Unread',
                'created_at' => now(),
            ]);
        }
    }
    private function sendAuctionWonNotification(Bid $bid)
    {
        Notification::create([
            'user_id' => $bid->buyer_id,
            'message' => "🎉 You won the auction for '{$bid->ticket->event_name}' with a bid of " . number_format($bid->bid_amount, 2) . " SAR! Please complete your payment within 24 hours to secure your ticket.",
            'type' => NotificationType::BID_UPDATE,
            'status' => 'Unread',
            'created_at' => now(),
        ]);

        // Additional email or SMS notification can be added here
    }

    private function sendAuctionLostNotifications($ticketId, $winningBidId)
    {
        $losingBids = Bid::where('ticket_id', $ticketId)
            ->where('bid_id', '!=', $winningBidId)
            ->where('status', 'rejected')
            ->with('ticket', 'buyer')
            ->get();

        foreach ($losingBids as $bid) {
            Notification::create([
                'user_id' => $bid->buyer_id,
                'message' => "The auction for '{$bid->ticket->event_name}' has ended. Unfortunately, your bid was not the winning bid. Thank you for participating!",
                'type' => NotificationType::BID_UPDATE,
                'status' => 'Unread',
                'created_at' => now(),
            ]);
        }
    }

    private function sendAuctionEndedNoBidsNotification(Ticket $ticket)
    {
        Notification::create([
            'user_id' => $ticket->seller_id,
            'message' => "Your auction for '{$ticket->event_name}' ended with no bids. The ticket has been marked as expired.",
            'type' => NotificationType::BID_UPDATE,
            'status' => 'Unread',
            'created_at' => now(),
        ]);
    }
}
