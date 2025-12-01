@extends('shared.app')

@section('content')
    <section class="mb-5">
        <div id="eventCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                        aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="{{asset('images/1.jpg')}}" class="d-block w-100" alt="Riyadh Season">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold animate__animated animate__fadeInDown">Riyadh Season: Discover the Best Events</h3>
                        <p class="animate__animated animate__fadeInUp animate__delay-1s">Exclusive tickets for concerts, shows, and
                            more.</p>
                        <a href="#"
                           class="btn btn-primary btn-lg mt-3 animate__animated animate__fadeInUp animate__delay-2s">Discover Now</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="https://placehold.co/1920x1080/5a54e3/e2eafc?text=International+Sports+Matches"
                         class="d-block w-100" alt="International Sports Matches">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold animate__animated animate__fadeInDown">International Sports Matches</h3>
                        <p class="animate__animated animate__fadeInUp animate__delay-1s">Book your seat for top football and boxing
                            matches.</p>
                        <a href="#" class="btn btn-primary btn-lg mt-3 animate__animated animate__fadeInUp animate__delay-2s">Book
                            Now</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="https://placehold.co/1920x1080/9e9e9e/f0f0f0?text=Live+Concerts" class="d-block w-100"
                         alt="Live Concerts">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold animate__animated animate__fadeInDown">Live Concerts</h3>
                        <p class="animate__animated animate__fadeInUp animate__delay-1s">Don’t miss a moment with original concert
                            tickets.</p>
                        <a href="#" class="btn btn-primary btn-lg mt-3 animate__animated animate__fadeInUp animate__delay-2s">Browse
                            Concerts</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <div id="content-container">
        <!-- Latest Tickets -->
        <section class="custom-section bg-light-custom">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title d-inline-block">Your Next Adventure Awaits</h2>
                    <p class="section-subtitle">Discover the latest and most trending tickets available now.</p>
                </div>
                <div class="row g-4">
                    @foreach($tickets as $ticket)
                        @include('shared.ticket_card', ['ticket' => $ticket])
                    @endforeach
                </div>
                <div class="text-center mt-5 animate-on-scroll">
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                        View All Tickets <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="custom-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title d-inline-block">How Eventick Works</h2>
                    <p class="section-subtitle">Eventick empowers everyone with powerful, easy-to-use tools.</p>
                </div>
                <div class="row g-4 text-center justify-content-center">
                    <!-- Buyer Card -->
                    <div class="col-md-6 col-lg-4 animate-on-scroll">
                        <div class="card p-4 h-100">
                            <div class="card-body">
                                <i class="fa-solid fa-user-tag feature-icon"></i>
                                <h5 class="card-title fw-bold mb-3">For Buyers</h5>
                                <p class="card-text">
                                    Buy tickets securely, join auctions, and get dynamic QR codes for entry.
                                </p>
                                <ul class="list-unstyled text-start mt-4 small">
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> Browse & purchase tickets</li>
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> Auctions & notifications</li>
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> Secure dynamic QR codes</li>
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> Account management</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Seller Card -->
                    <div class="col-md-6 col-lg-4 animate-on-scroll">
                        <div class="card p-4 h-100">
                            <div class="card-body">
                                <i class="fa-solid fa-store feature-icon"></i>
                                <h5 class="card-title fw-bold mb-3">For Sellers</h5>
                                <p class="card-text">
                                    List and sell tickets easily with fixed pricing or auctions, and receive payments securely.
                                </p>
                                <ul class="list-unstyled text-start mt-4 small">
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> List & manage tickets</li>
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> Choose selling methods</li>
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> Secure payment processing</li>
                                    <li><i class="fa-solid fa-check text-primary me-2"></i> Receive notifications</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Join Us Section -->
        <section class="join-us-section text-center animate-on-scroll">
            <div class="container">
                <h2 class="fw-bold mb-3">Ready to Join the Revolution?</h2>
                <p class="lead mb-4">Start buying and selling tickets with peace of mind. Join the Eventick community today!</p>
                <a href="#" class="btn btn-light btn-lg rounded-pill px-5">Create Your Account <i
                        class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </section>

    </div>
@endsection
