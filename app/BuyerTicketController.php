<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::where('buyer_id', Auth::id())
            ->where('status', 'Sold')
            ->with(['seller', 'transaction'])
            ->orderBy('event_date', 'desc');

        // Apply filters
        if ($request->has('event_type') && $request->event_type != '') {
            $query->where('event_type', $request->event_type);
        }

        if ($request->has('date_range')) {
            switch ($request->date_range) {
                case 'upcoming':
                    $query->where('event_date', '>', now());
                    break;
                case 'past':
                    $query->where('event_date', '<', now());
                    break;
                case 'this_week':
                    $query->whereBetween('event_date', [now(), now()->addWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('event_date', [now(), now()->addMonth()]);
                    break;
            }
        }

        $tickets = $query->paginate(12);

        return view('buyer.tickets.index', compact('tickets'));
    }

    public function download($ticketId)
    {
        $ticket = Ticket::where('ticket_id', $ticketId)->where('buyer_id', Auth::id())->firstOrFail();
        return response()->json([
            'success' => true,
            'message' => 'Ticket downloaded successfully',
            'ticket' => $ticket
        ]);
    }

    public function show($ticketId)
    {
        $ticket = Ticket::where('ticket_id', $ticketId)
            ->where('buyer_id', Auth::id())
            ->with(['seller', 'transaction'])
            ->firstOrFail();

        return view('buyer.tickets.show', compact('ticket'));
    }
}
