<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Bid;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_tickets' => Ticket::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('payment_status', 'Verified')->sum('amount'),
            'pending_tickets' => Ticket::where('status', 'PendingReview')->count(),
            'active_auctions' => Ticket::where('selling_method', 'Auction')
                ->where('status', 'Available')
                ->where('auction_end_date', '>', now())
                ->count(),
            'verified_transactions' => Transaction::where('payment_status', 'Verified')->count(),
            'pending_transactions' => Transaction::where('payment_status', 'Pending')->count(),
        ];

        // Recent activities
        $recentTickets = Ticket::with('seller')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentTransactions = Transaction::with(['buyer', 'ticket'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTickets', 'recentTransactions', 'recentUsers'));
    }

    public function users(Request $request)
    {
        $users = User::with(['role'])
            ->withCount(['tickets', 'bids', 'transactions'])
            ->where('role_id', '!=', 1) // Exclude admins
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function suspendUser($id)
    {
        $user = User::where('role_id', '!=', 1)->findOrFail($id);

        $user->update(['status' => 'Suspended']);

        return redirect()->back()->with('success', 'User suspended successfully.');
    }

    public function activateUser($id)
    {
        $user = User::where('role_id', '!=', 1)->findOrFail($id);

        $user->update(['status' => 'Active']);

        return redirect()->back()->with('success', 'User activated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::where('role_id', '!=', 1)->findOrFail($id);

        $user->update(['status' => 'Deleted']);

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function tickets()
    {
        $tickets = Ticket::with(['seller', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tickets', compact('tickets'));
    }

    public function approveTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update(['status' => 'Available']);

        return redirect()->back()->with('success', 'Ticket approved successfully.');
    }

    public function rejectTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update(['status' => 'Suspended']);

        return redirect()->back()->with('success', 'Ticket rejected and suspended.');
    }

    public function suspendTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update(['status' => 'Suspended']);

        return redirect()->back()->with('success', 'Ticket suspended successfully.');
    }

    public function activateTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update(['status' => 'Available']);

        return redirect()->back()->with('success', 'Ticket activated successfully.');
    }

    public function transactions()
    {
        $transactions = Transaction::with(['buyer', 'seller', 'ticket'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }


    public function complaints(Request $request)
    {
        $query = Complaint::with(['user'])
            ->orderBy('created_at', 'desc');


        $complaints = $query->get();

        return view('admin.complaints', compact('complaints'));
    }

    public function resolveComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'status' => 'Resolved',
            'admin_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Complaint marked as resolved.');
    }

    public function rejectComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'status' => 'Rejected',
            'admin_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Complaint rejected.');
    }

    public function reopenComplaint($id)
    {
        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'status' => 'Pending',
            'admin_id' => null
        ]);

        return redirect()->back()->with('success', 'Complaint reopened.');
    }
}
