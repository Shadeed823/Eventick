@extends('shared.app_user')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Users Management</h1>
                <p class="text-muted mb-0">Manage all registered users on the platform</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Users Table -->
        <div class="card">
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Contact</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                @if($user->role->role_id != 1) {{-- Exclude admins --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small class="text-muted">ID: {{ $user->user_id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="small">{{ $user->email }}</div>
                                            <small class="text-muted">{{ $user->phone ?? 'No phone' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->role->role_id == 2 ? 'info' : 'primary' }}">
                                            {{ $user->role->role_id == 2 ? 'Seller' : 'Buyer' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->status == 'Active' ? 'success' : ($user->status == 'Suspended' ? 'warning' : 'danger') }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- Status Actions -->
                                            @if($user->status == 'Active')
                                                <form action="{{ route('admin.users.suspend', $user->user_id) }}" method="POST" class="d-inline ">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning mr-3" title="Suspend User">
                                                        <i class="fas fa-pause"></i>
                                                    </button>
                                                </form>
                                            @elseif($user->status == 'Suspended')
                                                <form action="{{ route('admin.users.activate', $user->user_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" title="Activate User">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($user->status != 'Deleted')
                                                <form action="{{ route('admin.users.delete', $user->user_id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Delete User">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No users found</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
