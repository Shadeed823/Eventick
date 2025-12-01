@extends('shared.app_user')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Complaints Management</h1>
                <p class="text-muted mb-0">Manage user complaints and suggestions</p>
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


        <!-- Complaints Table -->
        <div class="card">
            <div class="card-body">
                @if($complaints->count() > 0)
                    <div class="table-responsive">
                        <table class="table tableData table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Subject</th>
                                <th>Message Preview</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($complaints as $complaint)
                                <tr>
                                    <td>
                                        @if($complaint->user_id)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-2">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                         style="width: 32px; height: 32px;">
                                                        <span class="text-white fw-bold small">{{ strtoupper(substr($complaint->user->name, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 small">{{ $complaint->user->name }}</h6>
                                                    <small class="text-muted">{{ $complaint->user->email }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <div>
                                                <h6 class="mb-0 small">{{ $complaint->name }}</h6>
                                                <small class="text-muted">{{ $complaint->email }}</small>
                                                <span class="badge bg-secondary ms-1">Guest</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $complaint->subject }}</strong>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-0 small">
                                            {{ Str::limit($complaint->description, 50) }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{
                                            $complaint->status === 'Pending' ? 'warning' :
                                            ($complaint->status === 'Resolved' ? 'success' : 'danger')
                                        }}">
                                            {{ $complaint->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $complaint->created_at->format('M d, Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $complaint->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- View Button -->
                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#complaintModal{{ $complaint->complaint_id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Status Actions -->
                                            @if($complaint->status === 'Pending')
                                                <form action="{{ route('admin.complaints.resolve', $complaint->complaint_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" title="Mark as Resolved">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.complaints.reject', $complaint->complaint_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @elseif($complaint->status === 'Resolved')
                                                <form action="{{ route('admin.complaints.reopen', $complaint->complaint_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning" title="Reopen">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @elseif($complaint->status === 'Rejected')
                                                <form action="{{ route('admin.complaints.reopen', $complaint->complaint_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning" title="Reopen">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Complaint Modal -->
                                <div class="modal fade" id="complaintModal{{ $complaint->complaint_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Complaint Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>User Information</h6>
                                                        @if($complaint->user_id)
                                                            <p><strong>Name:</strong> {{ $complaint->user->name }}</p>
                                                            <p><strong>Email:</strong> {{ $complaint->user->email }}</p>
                                                            <p><strong>Phone:</strong> {{ $complaint->user->phone ?? 'Not provided' }}</p>
                                                            <p><strong>User Type:</strong> Registered User</p>
                                                        @else
                                                            <p><strong>Name:</strong> {{ $complaint->name }}</p>
                                                            <p><strong>Email:</strong> {{ $complaint->email }}</p>
                                                            <p><strong>User Type:</strong> Guest</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Complaint Information</h6>
                                                        <p><strong>Subject:</strong> {{ $complaint->subject }}</p>
                                                        <p><strong>Status:</strong>
                                                            <span class="badge bg-{{
                                                                $complaint->status === 'Pending' ? 'warning' :
                                                                ($complaint->status === 'Resolved' ? 'success' : 'danger')
                                                            }}">
                                                                {{ $complaint->status }}
                                                            </span>
                                                        </p>
                                                        <p><strong>Submitted:</strong> {{ $complaint->created_at->format('M d, Y H:i') }}</p>
                                                        <p><strong>Last Updated:</strong> {{ $complaint->updated_at->format('M d, Y H:i') }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h6>Message</h6>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-0">{{ $complaint->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                @if($complaint->status === 'Pending')
                                                    <form action="{{ route('admin.complaints.resolve', $complaint->complaint_id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-check me-1"></i> Mark Resolved
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.complaints.reject', $complaint->complaint_id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times me-1"></i> Reject
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
            </div>
        </div>
    </div>

@endsection
