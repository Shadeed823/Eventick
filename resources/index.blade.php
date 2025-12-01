@extends('shared.app')
@push('css')
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .btn-group .btn {
            border-radius: 6px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
        }

        #ticketsList .card {
            border-radius: 8px;
        }
    </style>
@endpush
@section('content')
    <!-- Page Header Section -->
    <header class="page-header">
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
                </ol>
            </nav>
            <h1 class="page-title">Available Tickets</h1>
            <p class="lead">
                Find the perfect tickets for your next event
            </p>
        </div>
    </header>
    <div class="container p-2">

        <div id="content-container">
            <!-- Results Count -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="text-muted mb-0">
                    Showing {{ $tickets->firstItem() }} - {{ $tickets->lastItem() }} of {{ $tickets->total() }} tickets
                </p>

                <!-- View Toggle -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" id="gridView">
                        <i class="fas fa-th"></i> Grid
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="listView">
                        <i class="fas fa-list"></i> List
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <!-- Filter Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('tickets.index') }}" class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Event Name</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search events..."
                                           value="{{ request('search') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Selling Method</label>
                                    <select name="selling_method" class="form-select">
                                        <option value="">All Methods</option>
                                        <option value="Fixed" {{ request('selling_method') == 'Fixed' ? 'selected' : '' }}>Fixed Price</option>
                                        <option value="Auction" {{ request('selling_method') == 'Auction' ? 'selected' : '' }}>Auction</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Min Price (SAR)</label>
                                    <input type="number" name="min_price" class="form-control" placeholder="Min"
                                           value="{{ request('min_price') }}" min="0">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Max Price (SAR)</label>
                                    <input type="number" name="max_price" class="form-control" placeholder="Max"
                                           value="{{ request('max_price') }}" min="0">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Event Date</label>
                                    <select name="date_range" class="form-select">
                                        <option value="">All Dates</option>
                                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                                        <option value="tomorrow" {{ request('date_range') == 'tomorrow' ? 'selected' : '' }}>Tomorrow</option>
                                        <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week</option>
                                        <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This Month</option>
                                        <option value="upcoming" {{ request('date_range') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Sort By</label>
                                    <select name="sort" class="form-select">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="event_soon" {{ request('sort') == 'event_soon' ? 'selected' : '' }}>Event Date: Soonest</option>
                                        <option value="event_late" {{ request('sort') == 'event_late' ? 'selected' : '' }}>Event Date: Latest</option>
                                    </select>
                                </div>

                                <div class="col-md-12 d-flex flex-column">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-filter me-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('tickets.index') }}" class="btn mt-3 btn-outline-secondary">
                                        <i class="fas fa-sync me-1"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <!-- Tickets Grid -->
                    <div class="row" id="ticketsGrid">
                        @forelse($tickets as $ticket)
                            @include('shared.ticket_card', ['ticket' => $ticket])
                        @empty
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center py-5">
                                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No tickets found</h5>
                                        <p class="text-muted">Try adjusting your filters or check back later for new tickets.</p>
                                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                                            <i class="fas fa-sync me-1"></i> Clear Filters
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Tickets List (Hidden by default) -->
                    <div class="d-none" id="ticketsList">
                        @forelse($tickets as $ticket)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="{{ asset('images/tick.png') }}" alt="{{ $ticket->event_name }}"
                                                 class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="card-title">{{ $ticket->event_name }}</h5>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><i class="fas fa-calendar-alt text-muted me-2"></i>
                                                        {{ $ticket->event_date }}
                                                    </p>
                                                    <p class="mb-1"><i class="fas fa-clock text-muted me-2"></i>
                                                        {{ date('h:i A',strtotime( $ticket->event_date)) }}
                                                    </p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1"><i class="fas fa-chair text-muted me-2"></i>
                                                        {{ $ticket->seat_number ?? 'General' }}
                                                    </p>
                                                    <p class="mb-1"><i class="fas fa-user-tag text-muted me-2"></i>
                                                        {{ $ticket->seller->name }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                <span class="badge bg-{{ $ticket->selling_method === 'Auction' ? 'info' : 'warning' }} me-2">
                                    {{ $ticket->selling_method }}
                                </span>
                                                <span class="badge bg-{{ $ticket->status === 'Available' ? 'success' : 'secondary' }}">
                                    {{ $ticket->status }}
                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <div class="h4 text-primary mb-3">{{ number_format($ticket->price, 2) }} SAR</div>
                                            <a href="{{ route('tickets.show', $ticket->ticket_id) }}" class="btn btn-primary">
                                                <i class="fas fa-eye me-1"></i> View Details
                                            </a>
                                            @if($ticket->selling_method === 'Auction' && $ticket->auction_end_date)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Ends: {{ date('M d, Y',strtotime( $ticket->auction_end_date)) }}

                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty state already handled in grid view -->
                        @endforelse
                    </div>
                </div>
            </div>




        <!-- Pagination -->
        @if($tickets->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $tickets->links() }}
            </div>
        @endif


    </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View toggle functionality
            const gridViewBtn = document.getElementById('gridView');
            const listViewBtn = document.getElementById('listView');
            const ticketsGrid = document.getElementById('ticketsGrid');
            const ticketsList = document.getElementById('ticketsList');

            gridViewBtn.addEventListener('click', function() {
                ticketsGrid.classList.remove('d-none');
                ticketsList.classList.add('d-none');
                gridViewBtn.classList.add('active');
                listViewBtn.classList.remove('active');
            });

            listViewBtn.addEventListener('click', function() {
                ticketsGrid.classList.add('d-none');
                ticketsList.classList.remove('d-none');
                gridViewBtn.classList.remove('active');
                listViewBtn.classList.add('active');
            });

            // Price range validation
            const minPriceInput = document.querySelector('input[name="min_price"]');
            const maxPriceInput = document.querySelector('input[name="max_price"]');

            minPriceInput?.addEventListener('change', function() {
                if (maxPriceInput.value && parseInt(this.value) > parseInt(maxPriceInput.value)) {
                    this.value = maxPriceInput.value;
                }
            });

            maxPriceInput?.addEventListener('change', function() {
                if (minPriceInput.value && parseInt(this.value) < parseInt(minPriceInput.value)) {
                    this.value = minPriceInput.value;
                }
            });

            // Auto-submit form when certain filters change
            const autoSubmitFilters = document.querySelectorAll('select[name="sort"], select[name="date_range"]');
            autoSubmitFilters.forEach(select => {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        });
    </script>
@endsection
