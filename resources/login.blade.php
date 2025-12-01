@extends('shared.app')

@section('content')

    <!-- Page Header -->
    <header class="page-header">
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </nav>
            <h1 class="page-title">Welcome Back!</h1>
            <p class="lead">Login to access your account</p>
        </div>
    </header>

    <!-- Login Section -->
    <section class="login-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm login-card">
                        <div class="card-body">
                            <h4 class="mb-4 text-center">Sign in to Eventick</h4>

                            <form method="POST" action="{{ route('login') }}">
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

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               required>
                                        <span class="input-group-text password-toggle" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Remember Me -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100">Login</button>

                                <!-- Extra Links -->
                                <div class="mt-4 text-center">
                                    <a href="{{ route('password.request') }}" class="me-3">Forgot Password?</a>
                                    <p class="mt-2">Don’t have an account?
                                        <a href="{{ route('register') }}" class="text-primary">Create one</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
