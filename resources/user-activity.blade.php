@extends('shared.app_user')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">User Activity Report</h1>
                <p class="text-muted mb-0">User engagement and performance analysis</p>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-1"></i> Apply Filters
                        </button>
                        <a href="{{ route('admin.reports.user-activity') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-sync me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="card-text">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Active Users</h5>
                        <h2 class="card-text">{{ $activeUsers }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Suspended Users</h5>
                        <h2 class="card-text">{{ $suspendedUsers }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Date Range</h5>
                        <h6 class="card-text">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</h6>
                        <h6 class="card-text">to</h6>
                        <h6 class="card-text">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="row mb-4">
            <!-- Top Sellers -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">🏆 Top Sellers</h5>
                    </div>
                    <div class="card-body">
                        @if($topSellers->count() > 0)
                            @foreach($topSellers as $user)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-truncate">{{ $user->name }}</span>
                                    <span class="badge bg-success">{{ $user->sales_made }} sales</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">No sales data available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Buyers -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">🛒 Top Buyers</h5>
                    </div>
                    <div class="card-body">
                        @if($topBuyers->count() > 0)
                            @foreach($topBuyers as $user)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-truncate">{{ $user->name }}</span>
                                    <span class="badge bg-primary">{{ $user->purchases_made }} purchases</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">No purchase data available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Bidders -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">⚡ Most Active Bidders</h5>
                    </div>
                    <div class="card-body">
                        @if($mostActiveBidders->count() > 0)
                            @foreach($mostActiveBidders as $user)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-truncate">{{ $user->name }}</span>
                                    <span class="badge bg-warning">{{ $user->bids_made }} bids</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">No bidding data available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Activity Details</h5>
            </div>
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Tickets Listed</th>
                                <th>Tickets Bought</th>
                                <th>Bids Made</th>
                                <th>Purchases</th>
                                <th>Sales</th>
                                <th>Joined</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 32px; height: 32px;">
                                                    <span class="text-white fw-bold small">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 small">{{ $user->name }}</h6>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->role->role_id == 2 ? 'info' : 'primary' }}">
                                            {{ $user->role->role_id == 2 ? 'Seller' : 'Buyer' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->status == 'Active' ? 'success' : 'danger' }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td><span class="badge bg-info">{{ $user->tickets_listed }}</span></td>
                                    <td><span class="badge bg-primary">{{ $user->tickets_bought }}</span></td>
                                    <td><span class="badge bg-warning">{{ $user->bids_made }}</span></td>
                                    <td><span class="badge bg-success">{{ $user->purchases_made }}</span></td>
                                    <td><span class="badge bg-danger">{{ $user->sales_made }}</span></td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No users found</h5>
                        <p class="text-muted">Try adjusting your date range</p>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
