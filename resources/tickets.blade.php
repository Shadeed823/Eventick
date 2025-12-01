@extends('shared.app_user')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Tickets Management</h1>
                <p class="text-muted mb-0">Manage all tickets on the platform</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tickets Table -->
        <div class="card">
            <div class="card-body">
                @if($tickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table tableData table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>Event</th>
                                <th>Seller</th>
                                <th>Price</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Event Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $ticket->event_name }}</h6>
                                        <small class="text-muted">Seat: {{ $ticket->seat_number ?? 'General' }}</small>
                                    </td>
                                    <td>
                                        <div class="small">{{ $ticket->seller->name }}</div>
                                        <small class="text-muted">{{ $ticket->seller->email }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ number_format($ticket->price, 2) }} SAR</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->selling_method === 'Auction' ? 'info' : 'warning' }}">
                                            {{ $ticket->selling_method }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{
                                            $ticket->status === 'Available' ? 'success' :
                                            ($ticket->status === 'PendingReview' ? 'warning' :
                                            ($ticket->status === 'Sold' ? 'primary' :
                                            ($ticket->status === 'Expired' ? 'secondary' : 'danger')))
                                        }}">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $ticket->event_date }}</small>
                                        <br>
                                        <small class="text-muted">{{ $ticket->event_date }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- Status Actions -->
                                            @if($ticket->status === 'PendingReview')
                                                <form action="{{ route('admin.tickets.approve', $ticket->ticket_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" title="Approve Ticket">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.tickets.reject', $ticket->ticket_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" title="Reject Ticket">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @elseif($ticket->status === 'Available')
                                                <form action="{{ route('admin.tickets.suspend', $ticket->ticket_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning" title="Suspend Ticket">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
                                                </form>
                                            @elseif($ticket->status === 'Suspended')
                                                <form action="{{ route('admin.tickets.activate', $ticket->ticket_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" title="Activate Ticket">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- View Details Button -->
                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ticketModal{{ $ticket->ticket_id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Ticket Modal -->
                                <div class="modal fade" id="ticketModal{{ $ticket->ticket_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ticket Details: {{ $ticket->event_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Event Information</h6>
                                                        <p><strong>Event Name:</strong> {{ $ticket->event_name }}</p>
                                                        <p><strong>Event Date:</strong> {{ $ticket->event_date }}</p>
                                                        <p><strong>Seat Number:</strong> {{ $ticket->seat_number ?? 'General Admission' }}</p>
                                                        <p><strong>Price:</strong> {{ number_format($ticket->price, 2) }} SAR</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Seller Information</h6>
                                                        <p><strong>Seller:</strong> {{ $ticket->seller->name }}</p>
                                                        <p><strong>Email:</strong> {{ $ticket->seller->email }}</p>
                                                        <p><strong>Phone:</strong> {{ $ticket->seller->phone ?? 'Not provided' }}</p>
                                                        <p><strong>Selling Method:</strong>
                                                            <span class="badge bg-{{ $ticket->selling_method === 'Auction' ? 'info' : 'warning' }}">
                                                                {{ $ticket->selling_method }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Ticket Status</h6>
                                                        <p><strong>Current Status:</strong>
                                                            <span class="badge bg-{{
                                                                $ticket->status === 'Available' ? 'success' :
                                                                ($ticket->status === 'PendingReview' ? 'warning' :
                                                                ($ticket->status === 'Sold' ? 'primary' :
                                                                ($ticket->status === 'Expired' ? 'secondary' : 'danger')))
                                                            }}">
                                                                {{ $ticket->status }}
                                                            </span>
                                                        </p>
                                                        <p><strong>Created:</strong> {{ $ticket->created_at }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Additional Info</h6>
                                                        @if($ticket->selling_method === 'Auction' && $ticket->auction_end_date)
                                                            <p><strong>Auction Ends:</strong> {{ $ticket->auction_end_date }}</p>
                                                        @endif
                                                        @if($ticket->buyer)
                                                            <p><strong>Buyer:</strong> {{ $ticket->buyer->name }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No tickets found</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
