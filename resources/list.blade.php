@extends('shared.app_user')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-0">My Payments</h1>
                <p class="text-muted mb-0">Track your payment history and status</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Payments</h5>
                        <h2 class="card-text">{{ count($payments) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Verified</h5>
                        <h2 class="card-text">{{ $payments->where('payment_status', 'Verified')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pending</h5>
                        <h2 class="card-text">{{ $payments->where('payment_status', 'Pending')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Failed</h5>
                        <h2 class="card-text">{{ $payments->where('payment_status', 'Failed')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="card">
            <div class="card-body">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover tableData">
                            <thead class="table-light">
                            <tr>
                                <th>Event</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3">
                                                <i class="fas fa-ticket-alt text-primary"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block">{{ $payment->ticket->event_name }}</strong>
                                                <small class="text-muted">
                                                    {{ $payment->ticket->event_date->format('M d, Y') }}
                                                    • {{ $payment->ticket->seat_number ?? 'General' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="h6 text-success mb-0">{{ number_format($payment->amount, 2) }} SAR</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-{{ $payment->payment_method == 'Credit Card' ? 'credit-card' : ($payment->payment_method == 'Apple Pay' ? 'mobile-alt' : 'university') }} me-1"></i>
                                            {{ $payment->payment_method }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($payment->payment_status == 'Verified')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i> Verified
                                            </span>
                                        @elseif($payment->payment_status == 'Pending')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i> Pending
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $payment->created_at->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('buyer.payment.show', $payment->ticket) }}" class="btn btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                                <button class="btn btn-success" title="Download Ticket" onclick="downloadTicket({{ $payment->ticket_id }})">
                                                    <i class="fas fa-download"></i>
                                                </button>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No payments found</h5>
                        <p class="text-muted">You haven't made any payments yet.</p>
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                            <i class="fas fa-ticket-alt me-1"></i> Browse Tickets
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>



    <script>
        function downloadTicket(ticketId) {
            // Simulate ticket download
            alert('Downloading ticket #' + ticketId);
            // In real implementation, this would trigger a file download
        }

        // Export functionality
        document.querySelector('[title="Export CSV"]')?.addEventListener('click', function() {
            alert('Exporting payment history to CSV');
        });
    </script>
@endsection

@push('css')
    <style>
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .card-body {
            padding: 1.5rem;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .btn-group .btn {
            border-radius: 6px;
            margin-right: 0.25rem;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush
