


<div class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle notification-btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        @if($unreadCount > 0)
            <span class="notification-badge">{{ $unreadCount }}</span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
        <li class="dropdown-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Notifications</h6>
                @if($unreadCount > 0)
                    <form action="{{ route('buyer.notifications.markAllAsRead') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark all as read">
                            Mark all read
                        </button>
                    </form>
                @endif
            </div>
        </li>
        <li><hr class="dropdown-divider"></li>

        @if($recentNotifications->count() > 0)
            @foreach($recentNotifications as $notification)
                <li class="notification-item {{ $notification->status === 'Unread' ? 'unread' : '' }}">
                    <a href="{{ route('buyer.notifications.index') }}" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                @switch($notification->type)
                                    @case('Bid Update')
                                        <i class="fas fa-gavel text-primary"></i>
                                        @break
                                    @case('Purchase Update')
                                        <i class="fas fa-shopping-cart text-success"></i>
                                        @break
                                    @case('Auction Update')
                                        <i class="fas fa-clock text-warning"></i>
                                        @break
                                    @case('Admin Notice')
                                        <i class="fas fa-shield-alt text-info"></i>
                                        @break
                                    @case('Complaint Response')
                                        <i class="fas fa-comments text-secondary"></i>
                                        @break
                                    @default
                                        <i class="fas fa-bell text-primary"></i>
                                @endswitch
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 notification-message">{{ Str::limit($notification->message, 60) }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            @if($notification->status === 'Unread')
                                <span class="badge bg-primary ms-2">New</span>
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        @else
            <li class="dropdown-item-text">
                <div class="text-center py-3">
                    <i class="fas fa-bell-slash text-muted mb-2"></i>
                    <p class="text-muted mb-0">No notifications</p>
                </div>
            </li>
        @endif

        <li><hr class="dropdown-divider"></li>
        <li>
            <a href="{{ route('buyer.notifications.index') }}" class="dropdown-item text-center">
                <i class="fas fa-eye me-1"></i> View all notifications
            </a>
        </li>
    </ul>
</div>
