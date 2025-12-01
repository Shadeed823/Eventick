@extends('shared.app_user')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Won Auctions</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                @if($wonAuctions->isEmpty())
                    <div class="alert alert-info">You have not won any auctions yet.</div>
                @else
                    <table class="table tableData table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Event</th>
                            <th>Winning Bid</th>
                            <th>Status</th>
                            <th>Won On</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($wonAuctions as $index => $auction)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $auction->ticket->event_name ?? 'N/A' }}</td>
                                <td>{{ number_format($auction->bid_amount, 2) }} SAR</td>
                                <td>
                                    @if($auction->payment_status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending Payment</span>
                                    @endif
                                </td>
                                <td>{{ $auction->bid_time }}</td>
                                <td>
                                    @if($auction->payment_status !== 'paid')
                                        <a href="{{ route('buyer.payment.show', $auction->ticket) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-credit-card"></i> Pay Now
                                        </a>
                                    @else
                                        <span class="text-muted">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
