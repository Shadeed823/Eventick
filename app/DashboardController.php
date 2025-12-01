<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id != \App\Constants\RoleType::ids()['Seller']) {
            abort(403, 'Unauthorized action.');
        }

        // 🔹 Stats
        $ticketsSold = Ticket::where('seller_id', $user->user_id)
            ->where('status', \App\Constants\TicketStatus::SOLD)
            ->count();

        $revenue = Transaction::where('seller_id', $user->user_id)
            ->where('payment_status', \App\Constants\PaymentStatus::VERIFIED)
            ->sum('amount');

        $activeListings = Ticket::where('seller_id', $user->user_id)
            ->where('status', \App\Constants\TicketStatus::AVAILABLE)
            ->count();

        // 🔹 Monthly revenue chart
        $monthlyRevenue = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->where('seller_id', $user->user_id)
            ->where('payment_status', \App\Constants\PaymentStatus::VERIFIED)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill empty months with 0
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = [];
        foreach (range(1, 12) as $m) {
            $chartData[] = $monthlyRevenue[$m] ?? 0;
        }

        return view('seller.dashboard', compact(
            'user',
            'ticketsSold',
            'revenue',
            'activeListings',
            'chartLabels',
            'chartData'
        ));
    }
}
