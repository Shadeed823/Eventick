@extends('shared.app')

@section('content')

    <!-- Page Header -->
    <header class="page-header">
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
            <h1 class="page-title">Get in Touch with Eventick Team</h1>
            <p class="lead">We're here to help with any inquiries or technical support you need</p>
        </div>
    </header>

    <!-- Main Content -->
    <div id="content-container">

        @if(session('success'))
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <!-- Contact Info Section -->
        <section class="custom-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title d-inline-block">How Can We Help You?</h2>
                    <p class="section-subtitle">Our support team is available 24/7 to answer your questions</p>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 animate-on-scroll">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h3 class="h4">Our Address</h3>
                            <p>Jubail Industrial City, King Fahd Street<br>Saudi Arabia</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 animate-on-scroll">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h3 class="h4">Call Us</h3>
                            <p>+966 13 123 4567<br>+966 55 123 4567</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 animate-on-scroll">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h3 class="h4">Email</h3>
                            <p>info@eventick.com<br>support@eventick.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section class="custom-section bg-light-custom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 animate-on-scroll">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="card-body">
                                <h2 class="section-title text-center mb-4">Have a Complaint or Suggestion?</h2>
                                <p class="text-center mb-4">We'd love to hear from you. Fill out the form and we'll get back to you shortly.</p>

                                <form action="{{ route('contact.submit') }}" method="POST" class="needs-validation" novalidate>
                                    @csrf

                                    @guest
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Full Name *</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           value="{{ old('name') }}" required>
                                                    <div class="invalid-feedback">Please enter your full name</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email *</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                           value="{{ old('email') }}" required>
                                                    <div class="invalid-feedback">Please enter a valid email</div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            You are logged in as <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
                                        </div>
                                        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                    @endguest

                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject *</label>
                                        <input type="text" class="form-control" id="subject" name="subject"
                                               value="{{ old('subject') }}" required>
                                        <div class="invalid-feedback">Please enter a subject</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Message *</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  rows="5" required>{{ old('description') }}</textarea>
                                        <div class="invalid-feedback">Please enter your message (minimum 10 characters)</div>
                                        <div class="form-text">Please provide detailed information about your complaint or suggestion.</div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I agree to the terms and conditions and privacy policy
                                            </label>
                                            <div class="invalid-feedback">You must agree before submitting</div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i> Send Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .contact-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .card {
            border-radius: 12px;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .section-title {
            font-weight: 700;
            color: #2c3e50;
        }

        .bg-light-custom {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.needs-validation');

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            // Character count for description
            const description = document.getElementById('description');
            const charCount = document.createElement('div');
            charCount.className = 'form-text text-end';
            charCount.textContent = '0 characters (minimum 10 required)';
            description.parentNode.appendChild(charCount);

            description.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = `${length} characters (minimum 10 required)`;

                if (length < 10) {
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                    charCount.classList.add('text-success');
                }
            });
        });
    </script>
@endsection
