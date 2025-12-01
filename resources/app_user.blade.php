<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard-Eventick</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="{{asset('css/user.css')}}">
    @stack('css')
</head>
<body>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="{{asset('images/logo1.png')}}">
        </div>
        <button class="toggle-sidebar" id="toggleSidebar">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
 @include('shared.sidebar_user')

</div>
<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="btn btn-outline-primary mobile-menu-btn d-lg-none" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">Dashboard</h1>
        </div>

        <div class="header-actions">
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="fas fa-search"></i>
            </div>

         @include('shared.not')
            <!-- Profile Menu -->
            <div class="dropdown profile-menu">
                <button class="btn profile-btn dropdown-toggle" type="button" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://placehold.co/40x40/0a497f/ffffff?text={{ strtoupper(substr(Auth::user()->name,0,1)) }}"
                         alt="Profile">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
     @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('js')
<script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleIcon = this.querySelector('i');
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        if (sidebar.classList.contains('collapsed')) {
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');
        } else {
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');
        }
    });
    document.getElementById('mobileMenuBtn').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('mobile-open');
    });
</script>

<!-- jQuery (needed for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $(".tableData").DataTable();
    });
</script>

</body>
</html>
