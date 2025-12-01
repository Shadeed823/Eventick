@extends('shared.app')

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
            <h1 class="page-title">About Eventick</h1>
            <p class="lead">A leading platform for buying and selling electronic tickets in Saudi Arabia</p>
        </div>
    </header>

    <!-- Main Content -->
    <div id="content-container">

        <!-- Who We Are Section -->
        <section class="custom-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 animate-on-scroll">
                        <h2 class="section-title">Who We Are</h2>
                        <p class="lead">Eventick is a leading Saudi platform specialized in buying and selling electronic tickets
                            for all kinds of events.</p>
                        <p>Founded in 2020, Eventick aims to revolutionize the way tickets are booked and traded in Saudi Arabia. We
                            provide innovative and secure solutions for both event organizers and attendees, while maintaining the
                            highest standards of quality and safety.</p>
                        <p>We are proud to be the trusted partner for the most important events in the Kingdom, from cultural
                            festivals and concerts to conferences, exhibitions, and sports events.</p>
                        <div class="mt-4">
                            <a href="{{route('contact')}}" class="btn btn-primary me-3">Contact Us</a>
                            <a href="#" class="btn btn-outline-primary">Explore Events</a>
                        </div>
                    </div>
                    <div class="col-lg-6 animate-on-scroll">
                        <img src="{{asset('images/logo1.png')}}" alt="Eventick Team" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision, Mission, Values -->
        <section class="custom-section bg-light-custom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 animate-on-scroll">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="fa-solid fa-bullseye feature-icon"></i>
                                <h3 class="card-title">Our Vision</h3>
                                <p class="card-text">To be the number one ticketing platform in the Middle East, transforming the
                                    experience of booking and trading tickets in the region.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 animate-on-scroll">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="fa-solid fa-rocket feature-icon"></i>
                                <h3 class="card-title">Our Mission</h3>
                                <p class="card-text">Empowering event organizers and audiences by providing a secure and easy-to-use
                                    platform for selling and buying electronic tickets.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 animate-on-scroll">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="fa-solid fa-gem feature-icon"></i>
                                <h3 class="card-title">Our Values</h3>
                                <p class="card-text">Transparency, security, innovation, excellence in customer service, and
                                    contributing to the development of the events industry in Saudi Arabia.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
