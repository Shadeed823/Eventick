@extends('shared.app_user')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Sales Report</h1>
                <p class="text-muted mb-0">Revenue and transaction analysis</p>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-1"></i> Apply Filters
                        </button>
                        <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-sync me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Revenue</h5>
                        <h2 class="card-text">{{ number_format($totalRevenue, 2) }} SAR</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Transactions</h5>
                        <h2 class="card-text">{{ $totalTransactions }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Avg. Transaction</h5>
                        <h2 class="card-text">{{ number_format($averageTransaction, 2) }} SAR</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Date Range</h5>
                        <h6 class="card-text">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</h6>
                        <h6 class="card-text">to</h6>
                        <h6 class="card-text">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method Statistics -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Revenue by Payment Method</h5>
                    </div>
                    <div class="card-body">
                        @if($paymentMethodStats->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Payment Method</th>
                                        <th>Transactions</th>
                                        <th>Total Revenue</th>
                                        <th>Percentage</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($paymentMethodStats as $method => $stats)
                                        <tr>
                                            <td>{{ $method }}</td>
                                            <td>{{ $stats['count'] }}</td>
                                            <td>{{ number_format($stats['total'], 2) }} SAR</td>
                                            <td>{{ $totalRevenue > 0 ? number_format(($stats['total'] / $totalRevenue) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No transaction data available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Transaction Details</h5>
            </div>
            <div class="card-body">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Transaction ID</th>
                                <th>Event</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                    <td>#{{ $transaction->transaction_id }}</td>
                                    <td>{{ $transaction->ticket->event_name ?? 'N/A' }}</td>
                                    <td>{{ $transaction->buyer->name ?? 'N/A' }}</td>
                                    <td>{{ $transaction->seller->name ?? 'N/A' }}</td>
                                    <td class="text-success fw-bold">{{ number_format($transaction->amount, 2) }} SAR</td>
                                    <td>
                                        <span class="badge bg-info">{{ $transaction->payment_method }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No transactions found</h5>
                        <p class="text-muted">Try adjusting your date range or filters</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
