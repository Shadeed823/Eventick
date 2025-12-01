<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="Eventick Logo" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ isActive('home') }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ isActive('tickets') }}" href="{{ route('tickets.index') }}">Explore Tickets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ isActive('about') }}" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ isActive('contact') }}" href="{{ route('contact') }}">Contact Us</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                @auth
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary me-2 {{ isActive('profile') }}">
                        <i class="fas fa-user"></i> Welcome : {{ Auth::user()->name }}
                        <span class="badge bg-primary text-white ms-2">
                {{ Auth::user()->role->role_name ?? '' }}
            </span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2 {{ isActive('login') }}">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary {{ isActive('register') }}">Sign Up</a>
                @endauth
            </div>

        </div>
    </div>
</nav>
