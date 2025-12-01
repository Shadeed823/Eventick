<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Constants\TicketSellingMethod;
use App\Constants\TicketStatus;

class TicketController extends Controller
{
    /**
     * Show seller's tickets
     */
    public function index()
    {
        $tickets = Ticket::where('seller_id', Auth::id())->latest()->paginate(10);

        return view('seller.tickets.index', compact('tickets'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('seller.tickets.create');
    }

    /**
     * Store new ticket (default PendingReview)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name'      => 'required|string|max:255',
            'event_date'      => 'required|date|after:today',
            'seat_number'     => 'nullable|string|max:50',
            'price'           => 'required|numeric|min:1',
            'selling_method'  => 'required|in:' . implode(',', [
                    TicketSellingMethod::FIXED,
                    TicketSellingMethod::AUCTION,
                ]),
            'auction_end_date'=> 'required_if:selling_method,' . TicketSellingMethod::AUCTION . '|nullable|date|after:event_date',

        ]);

        $validated['seller_id'] = Auth::id();
        $validated['status'] = TicketStatus::PENDING_REVIEW;

        Ticket::create($validated);

        return redirect()->route('seller.tickets.index')
            ->with('success', 'Ticket submitted for review. It will be visible once approved.');
    }

    /**
     * Edit ticket (only if still under review or available)
     */
    public function edit($id)
    {
        $ticket = Ticket::where('seller_id', Auth::id())->findOrFail($id);

        if (!in_array($ticket->status, [TicketStatus::PENDING_REVIEW, TicketStatus::AVAILABLE])) {
            return redirect()->back()->with('error', 'You can only edit tickets that are pending review or available.');
        }

        return view('seller.tickets.edit', compact('ticket'));
    }

    /**
     * Update ticket
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::where('seller_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'event_name'      => 'required|string|max:255',
            'event_date'      => 'required|date|after:today',
            'seat_number'     => 'nullable|string|max:50',
            'price'           => 'required|numeric|min:1',
            'selling_method'  => 'required|in:' . implode(',', [
                    TicketSellingMethod::FIXED,
                    TicketSellingMethod::AUCTION,
                ]),
            'auction_end_date'=> 'required_if:selling_method,' . TicketSellingMethod::AUCTION . '|nullable|date|after:event_date',

        ]);

        $ticket->update($validated);

        return redirect()->route('seller.tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Delete ticket
     */
    public function destroy($id)
    {
        $ticket = Ticket::where('seller_id', Auth::id())->findOrFail($id);

        if ($ticket->status === TicketStatus::SOLD) {
            return redirect()->back()->with('error', 'Sold tickets cannot be deleted.');
        }

        $ticket->delete();

        return redirect()->route('seller.tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
