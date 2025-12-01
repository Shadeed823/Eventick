@extends('shared.app')

@section('content')
    <!-- Page Header Section -->
    <header class="page-header">
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ticket Details</li>
                </ol>
            </nav>
            <h1 class="page-title">Ticket Details</h1>
            <p class="lead">
                Explore complete details of this event ticket, including seat info, seller details, price, and availability.
                Buy instantly or join the auction to secure your spot at the event!
            </p>
        </div>
    </header>


    <!-- Ticket Details Section -->
    <div class="ticket-container">
        <div class="ticket-card">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('images/tick.png') }}" class="ticket-image" alt="{{ $ticket->event_name }}">
                </div>
                <div class="col-md-8">
                    <div class="ticket-body">
                        <h1 class="event-title">{{ $ticket->event_name }}</h1>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="ticket-detail">
                                    <div class="ticket-icon">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="ticket-info">
                                        <p class="ticket-label">Event Date</p>
                                        <p class="ticket-value">{{ \Carbon\Carbon::parse($ticket->event_date)->format('F d, Y') }}</p>
                                    </div>
                                </div>

                                <div class="ticket-detail">
                                    <div class="ticket-icon">
                                        <i class="fas fa-chair"></i>
                                    </div>
                                    <div class="ticket-info">
                                        <p class="ticket-label">Seat Number</p>
                                        <p class="ticket-value">{{ $ticket->seat_number ?? 'General Admission' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="ticket-detail">
                                    <div class="ticket-icon">
                                        <i class="fas fa-user-tag"></i>
                                    </div>
                                    <div class="ticket-info">
                                        <p class="ticket-label">Seller</p>
                                        <p class="ticket-value">{{ $ticket->seller->name }}</p>
                                    </div>
                                </div>

                                <div class="ticket-detail">
                                    <div class="ticket-icon">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div class="ticket-info">
                                        <p class="ticket-label">Status</p>
                                        <p>
                                            @if($ticket->status == 'Available')
                                                <span class="badge status-badge bg-success">Available</span>
                                            @elseif($ticket->status == 'PendingReview')
                                                <span class="badge status-badge bg-warning">Pending Review</span>
                                            @elseif($ticket->status == 'Sold')
                                                <span class="badge status-badge bg-danger">Sold</span>
                                            @elseif($ticket->status == 'Expired')
                                                <span class="badge status-badge bg-secondary">Expired</span>
                                            @else
                                                <span class="badge status-badge bg-info">{{ $ticket->status }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="price-tag text-center my-4">
                            {{ number_format($ticket->price, 2) }} SAR
                        </div>

                        @if($ticket->status == 'Available')
                            @if($ticket->selling_method === 'Fixed')
                                <div class="text-center mt-4">
                                    <a href="{{ route('buyer.payment.create', $ticket) }}" class="btn btn-bid btn-lg text-white">
                                        <i class="fas fa-shopping-cart me-2"></i> Buy Now
                                    </a>
                                </div>
                            @else
                                <div class="bid-section">
                                    <h4 class="mb-4">Place Your Bid</h4>

                                    @if($ticket->selling_method === 'Auction')
                                        <div class="countdown-timer @if($ticket->auctionHasEnded()) auction-ended @endif" id="countdownContainer">
                                            <i class="fas fa-clock me-2"></i>
                                            @if($ticket->auctionHasEnded())
                                                <span class="text-danger">Auction Ended</span>
                                            @else
                                                Auction Ends In:
                                                <span id="countdown" data-end-date="{{ $ticket->auction_end_date }}">
                                                    Calculating...
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    @if($ticket->auctionHasEnded())
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            This auction has ended.
                                            @if($ticket->bids && $ticket->bids->count() > 0)
                                                The winning bid was {{ number_format($ticket->bids->max('bid_amount'), 2) }} SAR.
                                            @else
                                                There were no bids placed.
                                            @endif
                                        </div>
                                    @else
                                        <form id="bidForm" method="POST" action="{{ route('bids.store', $ticket->ticket_id) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="bidAmount" class="form-label">Your Bid Amount (SAR)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">SAR</span>
                                                    <input type="number" class="form-control" id="bidAmount" name="bid_amount"
                                                           min="{{ $ticket->price + 10 }}" step="5"
                                                           placeholder="Enter your bid amount" required>
                                                </div>
                                                <div class="form-text">Minimum bid: {{ number_format($ticket->price + 10, 2) }} SAR</div>
                                            </div>

                                            <button type="submit" class="btn btn-bid w-100 text-white" id="bidButton">
                                                <i class="fas fa-gavel me-2"></i> Place Bid
                                            </button>
                                        </form>
                                    @endif

                                    <div class="bid-history mt-4">
                                        <h5>Bid History</h5>

                                        @if($ticket->bids && $ticket->bids->count() > 0)
                                            @foreach($ticket->bids->sortByDesc('bid_time') as $bid)
                                                <div class="bid-item">
                                                    <div>
                                                        <span class="bid-amount">{{ number_format($bid->bid_amount, 2) }} SAR</span>
                                                        <span class="bidder-name">by {{ $bid->buyer->name }}</span>
                                                    </div>
                                                    <div class="bid-time">
                                                        {{ \Carbon\Carbon::parse($bid->bid_time)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">No bids yet. Be the first to bid!</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @elseif($ticket->status == 'Sold')
                            <div class="alert alert-info text-center mt-4">
                                <h5><i class="fas fa-ticket-alt me-2"></i> This ticket has been sold</h5>
                                @if($ticket->selling_method === 'Auction')
                                    <p>Winning bid: {{ number_format($ticket->price, 2) }} SAR</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@push('js')
    <script>
        // Countdown timer functionality
        function updateCountdown() {
            const countdownElement = document.getElementById("countdown");
            const countdownContainer = document.getElementById("countdownContainer");
            const bidForm = document.getElementById("bidForm");
            const bidButton = document.getElementById("bidButton");

            if (!countdownElement) return;

            const endDateString = countdownElement.dataset.endDate;
            const endDate = new Date(endDateString);
            const now = new Date();
            const distance = endDate - now;

            if (distance < 0) {
                // Auction has ended
                countdownElement.innerHTML = "Auction Ended";
                countdownContainer.classList.add("auction-ended");

                // Disable bidding form
                if (bidForm) {
                    bidForm.style.opacity = '0.6';
                    if (bidButton) {
                        bidButton.disabled = true;
                        bidButton.innerHTML = '<i class="fas fa-ban me-2"></i> Auction Ended';
                    }

                    // Create a message about auction ending
                    const endedMessage = document.createElement('div');
                    endedMessage.className = 'alert alert-info mt-3';
                    endedMessage.innerHTML = '<i class="fas fa-info-circle me-2"></i> This auction has ended.';
                    bidForm.parentNode.insertBefore(endedMessage, bidForm.nextSibling);
                }

                return;
            }

            // Calculate time remaining
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update countdown display
            countdownElement.innerHTML =
                days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            // Continue countdown
            setTimeout(updateCountdown, 1000);
        }

        // Form validation
        document.getElementById('bidForm')?.addEventListener('submit', function(e) {
            const bidAmount = parseFloat(document.getElementById('bidAmount').value);
            const minBid = parseFloat(document.getElementById('bidAmount').min);

            if (bidAmount < minBid) {
                e.preventDefault();
                alert('Your bid must be at least ' + minBid + ' SAR');
                return false;
            }
        });

        // Initialize countdown if we're on an auction page
        @if($ticket->selling_method === 'Auction' && $ticket->status == 'Available' && !$ticket->auctionHasEnded())
        document.addEventListener('DOMContentLoaded', function() {
            updateCountdown();
        });
        @endif

        // If auction has ended, disable the form
        @if($ticket->selling_method === 'Auction' && $ticket->auctionHasEnded())
        document.addEventListener('DOMContentLoaded', function() {
            const bidForm = document.getElementById('bidForm');
            const bidButton = document.getElementById('bidButton');

            if (bidForm && bidButton) {
                bidForm.style.opacity = '0.6';
                bidButton.disabled = true;
                bidButton.innerHTML = '<i class="fas fa-ban me-2"></i> Auction Ended';
            }
        });
        @endif
    </script>
@endpush
