<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Shree Ji Gau Sewa Society</title>
     <link rel="icon" href="https://gausevasociety.com/wp-content/uploads/2024/01/gaushala-logo.png" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.1);
        }
        .col-md-3.col-lg-2.d-md-block.sidebar.collapse {
            color: black;
            background-color: #f3f3f3;
        }
        a.nav-link {
            color: black !important;
        }
    </style>
    <style>
        .dashboard-header {
            background: #4B2AAD;
            color: #fff;
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }
        .dashboard-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            flex: 1;
            border-radius: 1.2rem;
            box-shadow: 0 2px 12px rgba(75,42,173,0.07);
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            background: linear-gradient(90deg, #f3eaff 60%, #ede7f6 100%);
            position: relative;
        }
        .stat-card .icon {
            font-size: 2.5rem;
            margin-right: 1.2rem;
            color: #4B2AAD;
        }
        .stat-card .stat-label {
            font-size: 1.1rem;
            color: #888;
            margin-bottom: 0.2rem;
        }
        .stat-card .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: #222;
        }
        .stat-card.wallet { background: linear-gradient(90deg, #f3eaff 60%, #ede7f6 100%); }
        .stat-card.count { background: linear-gradient(90deg, #eafff3 60%, #e7f6ed 100%); }
        .stat-card.volume { background: linear-gradient(90deg, #fff7ea 60%, #f6f0e7 100%); }
        .stat-card .lock-icon, .stat-card .cart-icon { position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.5rem; color: #b39ddb; }
        .stat-card .cart-icon { color: #4caf50; }
        .stat-card .lock-icon { color: #b39ddb; }
        .dashboard-table-card {
            border-radius: 1.2rem;
            box-shadow: 0 2px 12px rgba(75,42,173,0.07);
            margin-top: 2rem;
            background: #fff;
        }
        .dashboard-table-card .card-header {
            background: none;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            font-size: 1.2rem;
            color: #4B2AAD;
        }
        .dashboard-table-card .table {
            margin-bottom: 0;
        }
        .badge-success { background: #4caf50 !important; color: #fff; }
        .badge-warning { background: #ffb300 !important; color: #fff; }
        .badge-danger { background: #f44336 !important; color: #fff; }
        .badge-info { background: #7c4dff !important; color: #fff; }
        .txn-status-row {
            display: flex;
            justify-content: space-between;
            margin: 1.5rem 0 0.5rem 0;
        }
        .txn-status-row .status-box {
            flex: 1;
            text-align: center;
            padding: 0.7rem 0;
            border-radius: 2rem;
            margin: 0 0.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .status-success { background: #e8f5e9; color: #388e3c; }
        .status-pending { background: #fffde7; color: #fbc02d; }
        .status-failed { background: #ffebee; color: #d32f2f; }
        .status-refund { background: #ede7f6; color: #7c4dff; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <img src="https://gausevasociety.com/wp-content/uploads/2024/01/gaushala-logo.png" alt="Logo" style="max-width: 150px;">
                        <h4 class="mt-2">Admin Panel</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                                <i class="fas fa-users me-2"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.donations') ? 'active' : '' }}" href="{{ route('admin.donations') }}">
                                <i class="fas fa-donate me-2"></i> Donations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.celebrations') ? 'active' : '' }}" href="{{ route('admin.celebrations') }}">
                                <i class="fas fa-calendar-alt me-2"></i> Celebrations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reciepts') ? 'active' : '' }}" href="{{ route('admin.reciepts') }}">
                                <i class="fas fa-receipt me-2"></i> Receipt
                            </a>
                        </li>
                       <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.settings.show') ? 'active' : '' }}" href="{{ route('admin.settings.show') }}">
                                <i class="fa fa-cog"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom dashboard-header">
                    <h1 class="h2">@yield('title')</h1>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <!-- PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    @stack('scripts')
</body>
</html> 