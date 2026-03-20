<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }

        /* Sidebar */
        #sidebar {
            width: 240px;
            height: 100vh;
            background: #1a1d23;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }
        #sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,.3); }
        #sidebar .brand {
            padding: 1.4rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }
        #sidebar .brand span { color: #4ade80; }
        #sidebar .nav-link {
            color: rgba(255,255,255,.65);
            padding: .6rem 1.5rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .88rem;
            transition: background .15s, color .15s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(255,255,255,.07);
            color: #fff;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 20px; text-align: center; }
        #sidebar .nav-section {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(255,255,255,.3);
            padding: 1.2rem 1.5rem .4rem;
        }
        #sidebar .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 1rem 1.5rem;
        }
        #sidebar .sidebar-footer form button {
            background: none;
            border: none;
            color: rgba(255,255,255,.55);
            padding: 0;
            font-size: .88rem;
            display: flex; align-items: center; gap: .6rem;
            cursor: pointer;
        }
        #sidebar .sidebar-footer form button:hover { color: #f87171; }

        /* Topbar */
        #topbar {
            margin-left: 240px;
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 900;
            gap: .75rem;
        }
        #topbar .page-title {
            font-weight: 600;
            font-size: 1rem;
            color: #111827;
            margin: 0;
        }
        #topbar .ms-auto { display: flex; align-items: center; gap: .75rem; }
        #topbar .admin-badge {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #4ade80;
            color: #111;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: .8rem;
        }

        /* Main content */
        #main-content {
            margin-left: 240px;
            padding: 1.75rem;
            min-height: calc(100vh - 56px);
        }

        /* Cards */
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-card .icon-wrap {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }
        .stat-card .stat-value { font-size: 1.5rem; font-weight: 700; color: #111827; }
        .stat-card .stat-label { font-size: .78rem; color: #6b7280; }

        /* Tables */
        .table-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .table-card .table-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            font-size: .92rem;
            color: #111827;
            display: flex; align-items: center; justify-content: space-between;
        }
        .table thead th {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            padding: .75rem 1rem;
            background: #f9fafb;
        }
        .table td { padding: .75rem 1rem; vertical-align: middle; font-size: .875rem; }
        .table tbody tr:hover { background: #f9fafb; }

        /* Badges */
        .badge-status { font-size: .7rem; padding: .3em .65em; border-radius: 999px; }

        /* Sidebar overlay (mobile) */
        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 999;
        }
        #sidebarOverlay.show { display: block; }

        /* Mobile sidebar toggle */
        #sidebarToggle { display: none; }
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #topbar, #main-content { margin-left: 0; }
            #sidebarToggle { display: flex; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        🌿 <span>SEU</span> Admin
    </a>

    <div class="nav-section">Main</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    {{-- Users section removed — customers don't register --}}

    <div class="nav-section">Orders</div>
    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i> All Orders
    </a>

    <div class="nav-section">Sales</div>
    <a href="{{ route('admin.flash-sales.index') }}" class="nav-link {{ request()->routeIs('admin.flash-sales.*') ? 'active' : '' }}">
        <i class="bi bi-fire"></i> Flash Sales
    </a>
    <a href="{{ route('admin.flash-sales.create') }}" class="nav-link {{ request()->routeIs('admin.flash-sales.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> New Flash Sale
    </a>

    <div class="nav-section">Products</div>
    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="bi bi-bag"></i> Products
    </a>
    <a href="{{ route('admin.products.create') }}" class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> Add Product
    </a>

    <div class="nav-section">Communication</div>
    <a href="{{ route('admin.send.email') }}" class="nav-link {{ request()->routeIs('admin.send.email') ? 'active' : '' }}">
        <i class="bi bi-envelope"></i> Send Email
    </a>

    <div class="sidebar-footer">
        <a href="{{ route('admin.change.password') }}" class="nav-link {{ request()->routeIs('admin.change.password') ? 'active' : '' }}" style="padding:.6rem 0;">
            <i class="bi bi-key"></i> Change Password
        </a>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"><i class="bi bi-box-arrow-left"></i> Logout</button>
        </form>
    </div>
</nav>

<!-- Sidebar overlay -->
<div id="sidebarOverlay"></div>

<!-- Topbar -->
<div id="topbar">
    <button id="sidebarToggle" class="btn btn-sm btn-outline-secondary me-1" id="sidebarToggleBtn">
        <i class="bi bi-list"></i>
    </button>
    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
    <div class="ms-auto">
        <span class="text-muted" style="font-size:.82rem;">{{ Auth::guard('admin')->user()->email }}</span>
        <div class="admin-badge">A</div>
    </div>
</div>

<!-- Main content -->
<div id="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });
    }

    // Close on overlay tap/click
    overlay.addEventListener('click', closeSidebar);
    overlay.addEventListener('touchstart', closeSidebar, { passive: true });
</script>
@stack('scripts')
</body>
</html>
