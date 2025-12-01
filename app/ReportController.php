<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Sales Report - Show ticket sales and revenue
     */
    public function salesReport(Request $request)
    {
        // Default to current month if no date range provided
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $query = Transaction::with(['ticket', 'buyer', 'seller'])
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->where('payment_status', 'Verified');

        // Filter by payment method if provided
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalRevenue = $transactions->sum('amount');
        $totalTransactions = $transactions->count();
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Group by payment method
        $paymentMethodStats = $transactions->groupBy('payment_method')->map(function($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('amount')
            ];
        });

        // Daily revenue trend
        $dailyRevenue = $transactions->groupBy(function($transaction) {
            return $transaction->created_at->format('Y-m-d');
        })->map(function($group) {
            return $group->sum('amount');
        });

        return view('admin.reports.sales', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'averageTransaction',
            'paymentMethodStats',
            'dailyRevenue',
            'startDate',
            'endDate'
        ));
    }

    /**
     * User Activity Report - Show user engagement and activity
     */
    public function userActivityReport(Request $request)
    {
        // Default to last 30 days if no date range provided
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Get users with their activity counts
        $users = User::withCount([
            'ticketsSold as tickets_listed',
            'ticketsBought as tickets_bought',
            'bids as bids_made',
            'transactionsAsBuyer as purchases_made',
            'transactionsAsSeller as sales_made'
        ])
            ->where('role_id', '!=', 1) // Exclude admins
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate overall statistics
        $totalUsers = $users->count();
        $activeUsers = $users->where('status', 'Active')->count();
        $suspendedUsers = $users->where('status', 'Suspended')->count();

        // Top performers
        $topSellers = $users->sortByDesc('sales_made')->take(10);
        $topBuyers = $users->sortByDesc('purchases_made')->take(10);
        $mostActiveBidders = $users->sortByDesc('bids_made')->take(10);

        // User registration trend
        $registrationTrend = User::where('role_id', '!=', 1)
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        return view('admin.reports.user-activity', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'suspendedUsers',
            'topSellers',
            'topBuyers',
            'mostActiveBidders',
            'registrationTrend',
            'startDate',
            'endDate'
        ));
    }
}
