<?php

namespace App\Http\Controllers\Buyer;

use App\Constants\TicketSellingMethod;
use App\Constants\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $query = Transaction::where('buyer_id', Auth::id())
            ->with('ticket')
            ->orderBy('created_at', 'desc');
        $payments = $query->get();
        return view('buyer.payments.list', compact('payments'));
    }
    public function show(Ticket $ticket)
    {
        $wonBid = $ticket->bids()
            ->where('buyer_id', Auth::id())
            ->where('status', 'accepted')
            ->first();

        if (!$wonBid && $ticket->selling_method != TicketSellingMethod::FIXED) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'You are not authorized to pay for this ticket.');
        }

        $transaction = Transaction::where('ticket_id', $ticket->ticket_id)
            ->where('buyer_id', Auth::id())
            ->first();

        return view('buyer.payments.show', compact('ticket', 'wonBid', 'transaction'));
    }

    public function create(Ticket $ticket)
    {
        $wonBid = $ticket->bids()
            ->where('buyer_id', Auth::id())
            ->where('status', 'accepted')
            ->first();

        if (!$wonBid && $ticket->selling_method != TicketSellingMethod::FIXED) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'You are not authorized to pay for this ticket.');
        }

        return view('buyer.payments.index', compact('ticket', 'wonBid'));
    }

    public function process(Request $request, Ticket $ticket)
    {
        $request->validate([
            'payment_method' => 'required|in:Credit Card,Apple Pay,STC Pay,Bank Transfer',
        ]);

        $wonBid = $ticket->bids()
            ->where('buyer_id', Auth::id())
            ->where('status', 'accepted')
            ->first();

        if (!$wonBid && $ticket->selling_method != TicketSellingMethod::FIXED) {
            return redirect()->back()
                ->with('error', 'You are not authorized to pay for this ticket.');
        }

        $transaction = Transaction::updateOrCreate(
            [
                'ticket_id' => $ticket->ticket_id,
                'buyer_id' => Auth::id(),
            ],
            [
                'seller_id' => $ticket->seller_id,
                'amount' => $wonBid->bid_amount ?? $ticket->price,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Verified',
                'created_at' => now(),
            ]
        );
        $ticket->update([
            'buyer_id' => Auth::id(),
            'status' => TicketStatus::SOLD,
        ]);

        return redirect()->route('buyer.payment.show', $ticket)
            ->with('success', 'Payment processed successfully. Waiting for verification.');
    }
}
