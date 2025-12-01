@extends('shared.app')

@section('content')

    <!-- Page Header -->
    <header class="page-header">
        <div class="container position-relative">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
            </nav>
            <h1 class="page-title">Create Account</h1>
            <p class="lead">Join us and start buying or selling tickets</p>
        </div>
    </header>

    <!-- Register Section -->
    <section class="register-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card register-card shadow-sm">
                        <div class="card-body p-5">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <!-- Role Selection (Icons instead of Select) -->
                                <div class="mb-4">
                                    <label class="form-label d-block">Choose Your Role</label>
                                    <div class="d-flex justify-content-between">
                                        <!-- Seller -->
                                        <label class="role-option w-50 me-2">
                                            <input type="radio" name="role_id" value="2" class="d-none"
                                                {{ old('role_id') == 2 ? 'checked' : '' }}>
                                            <div class="role-card text-center p-2 border rounded cursor-pointer">
                                                <h6 class="mb-0">Seller</h6>
                                                <small class="text-muted">Sell your event tickets</small>
                                            </div>
                                        </label>

                                        <!-- Buyer -->
                                        <label class="role-option w-50 ms-2">
                                            <input type="radio" name="role_id" value="3" class="d-none"
                                                {{ old('role_id') == 3 ? 'checked' : '' }}>
                                            <div class="role-card text-center p-2 border rounded cursor-pointer">
                                                <h6 class="mb-0">Buyer</h6>
                                                <small class="text-muted">Find & buy tickets</small>
                                            </div>
                                        </label>
                                    </div>
                                    @error('role_id') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                </div>
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name') }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email') }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone') }}" required>
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>



                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary w-100">Register</button>

                                <p class="text-center mt-3">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="text-primary">Login</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('css')
    <style>
        .role-card {
            transition: all 0.3s ease;
        }
        .role-option input:checked + .role-card {
            border: 2px solid #0d6efd;
            background: #f0f8ff;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endpush
