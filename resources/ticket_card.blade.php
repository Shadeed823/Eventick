<div class="col-lg-4 col-md-6">
    <div class="card latest-ticket-card h-100 animate-on-scroll">
        <img src="{{ asset('images/tick.png') }}" class="card-img-top" alt="{{ $ticket->event_name }}">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge badgeeeee">{{ ucfirst($ticket->selling_method) }}</span>
                <span class="text-muted small">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($ticket->event_date)->format('M d, Y') }}
                </span>
            </div>
            <h5 class="card-title fw-bold">{{ $ticket->event_name }}</h5>
            <p class="card-text text-muted">
                Seat: {{ $ticket->seat_number ?? 'General' }}
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="price-tag fs-5">{{ number_format($ticket->price, 2) }} SAR</span>
                <a href="{{ route('tickets.show', $ticket->ticket_id) }}" class="btn btn-primary">View</a>
            </div>
        </div>
    </div>
</div>
