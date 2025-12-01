@extends('shared.app')

@section('content')

    <!-- Page Header -->
    <header class="page-header">
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                </ol>
            </nav>
            <h1 class="page-title">Forgot Password</h1>
            <p class="lead">Enter your email to reset your password</p>
        </div>
    </header>

    <!-- Forgot Password Section -->
    <section class="forgot-password-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-4 text-center">Reset Your Password</h4>

                            <form method="POST" action="#">
                                @csrf

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autofocus>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                            </form>

                            <div class="mt-4 text-center">
                                <a href="{{ route('login') }}" class="text-primary">Back to Login</a>
                            </div>
                        </div>
                    </div>

                    <p class="text-muted small text-center mt-3">
                        We’ll send you a password reset link if the email exists in our system.
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
