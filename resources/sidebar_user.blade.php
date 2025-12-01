<ul class="sidebar-menu">
    @if(auth()->user()->role->role_id == 3)
        <li>
            <a href="{{ route('buyer.dashboard') }}" class="{{ isActive('buyer.dashboard') }}">
                <i class="fas fa-home"></i> <span> Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('profile') }}" class="{{ isActive('profile') }}">
                <i class="fas fa-user"></i> <span>Profile</span>
            </a>
        </li>
        <li>
            <a href="{{ route('buyer.tickets.index') }}" class="{{ isActive('buyer.tickets.*') }}">
                <i class="fas fa-ticket-alt"></i> <span>My Tickets</span>
            </a>
        </li>
        <li>
            <a href="{{ route('buyer.bids.index') }}" class="{{ isActive('buyer.bids.*') }}">
                <i class="fas fa-gavel"></i> <span>My Bids</span>
            </a>
        </li>
        <li>
            <a href="{{ route('buyer.auctions.won') }}" class="{{ isActive('buyer.auctions.*') }}">
                <i class="fas fa-trophy"></i> <span>Won Auctions</span>
            </a>
        </li>
        <li>
            <a href="{{ route('buyer.payments.index') }}" class="{{ isActive('buyer.payments.*') }}">
                <i class="fas fa-credit-card"></i> <span>My Payments</span>
            </a>
        </li>
    @elseif(auth()->user()->role->role_id == 2)
        <li>
            <a href="{{ route('seller.dashboard') }}" class="{{ isActive('seller.dashboard') }}">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('profile') }}" class="{{ isActive('profile') }}">
                <i class="fas fa-user"></i> <span>Profile</span>
            </a>
        </li>

        <li>
            <a href="{{ route('seller.tickets.index') }}" class="{{ isActive('seller.tickets.*') }}">
                <i class="fas fa-ticket-alt"></i> <span>Tickets</span>
            </a>
        </li>
        <li>
            <a href="{{ route('seller.bids.index') }}" class="{{ isActive('seller.bids.*') }}">
                <i class="fas fa-gavel me-2"></i> <span>Bids</span>
            </a>
        </li>
    @else
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="{{ isActive('admin.dashboard.*') }}">
                <i class="fas fa-crown"></i> <span>Admin Panel</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users') }}" class="{{ isActive('admin.users.*') }}">
                <i class="fas fa-users"></i> <span>Manage Users</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.tickets.index') }}" class="{{ isActive('admin.tickets.*') }}">
                <i class="fas fa-file"></i> <span>Manage Tickets</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.complaints.index') }}" class="{{ isActive('admin.complaints.*') }}">
                <i class="fas fa-comments"></i> <span>Complaints</span>
                @if($pendingComplaintsCount > 0)
                    <span class="badge bg-danger float-end">{{ $pendingComplaintsCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.reports.sales') }}" class="{{ isActive('admin.reports.sales') }}">
                <i class="fas fa-chart-bar"></i> <span>Sales Report</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.reports.user-activity') }}" class="{{ isActive('admin.reports.user-activity') }}">
                <i class="fas fa-chart-bar"></i> <span>User Report</span>
            </a>
        </li>
    @endif
    <li>
        <a href="{{ route('home') }}" class="">
            <i class="fas fa-arrow-right"></i> <span>Visit Website</span>
        </a>
    </li>
</ul>
