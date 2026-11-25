<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FindIT — {{ config('app.name', 'FindIT') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #EEF2F7; color: #1e293b; min-height: 100vh; }

        /* ── Sidebar ───────────────────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 240px;
            background: #fff; border-right: 1px solid #e8edf3;
            display: flex; flex-direction: column; z-index: 100;
        }
        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; gap: 10px;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #185FA5, #2180d8);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-icon i { color: #fff; font-size: 18px; }
        .brand-name { font-size: 17px; font-weight: 600; color: #0f172a; letter-spacing: -0.3px; }
        .brand-name span { color: #185FA5; }
        .brand-sub { font-size: 10px; color: #94a3b8; margin-top: 1px; }

        .sidebar-nav { padding: 12px 10px; flex: 1; overflow-y: auto; }
        .nav-section-label {
            font-size: 10px; font-weight: 600; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.08em;
            padding: 8px 10px 4px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 13.5px; font-weight: 500; color: #475569;
            text-decoration: none; margin-bottom: 2px;
            transition: all 0.15s;
        }
        .nav-item i { font-size: 18px; width: 20px; text-align: center; }
        .nav-item:hover { background: #f1f5f9; color: #1e293b; }
        .nav-item.active { background: #EBF3FC; color: #185FA5; }
        .nav-item.active i { color: #185FA5; }
        .nav-badge {
            margin-left: auto; background: #ef4444; color: #fff;
            font-size: 10px; font-weight: 600; padding: 1px 6px;
            border-radius: 20px; min-width: 18px; text-align: center;
        }

        .sidebar-user {
            padding: 12px 16px;
            border-top: 1px solid #f1f5f9;
            display: flex; align-items: center; gap: 10px;
        }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #185FA5, #2180d8);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 600; color: #fff; flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 13px; font-weight: 500; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 11px; color: #94a3b8; }
        .logout-btn {
            width: 28px; height: 28px; border-radius: 6px;
            background: none; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8; transition: all 0.15s;
        }
        .logout-btn:hover { background: #fee2e2; color: #ef4444; }

        /* ── Main content ──────────────────────────────────────── */
        .main-content { margin-left: 240px; min-height: 100vh; }

        .topbar {
            background: #fff; border-bottom: 1px solid #e8edf3;
            padding: 0 28px; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-left { display: flex; align-items: center; gap: 8px; }
        .topbar-title { font-size: 15px; font-weight: 600; color: #0f172a; }
        .topbar-sub { font-size: 12px; color: #94a3b8; }
        .topbar-right { display: flex; align-items: center; gap: 8px; }

        .page-body { padding: 24px 28px; }

        /* ── Cards ────────────────────────────────────────────── */
        .card { background: #fff; border-radius: 12px; border: 1px solid #e8edf3; }
        .card-header {
            padding: 14px 18px; border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 14px; font-weight: 600; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .card-title i { font-size: 16px; color: #64748b; }
        .card-body { padding: 18px; }

        /* ── Stat cards ───────────────────────────────────────── */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
        .stat-card {
            background: #fff; border-radius: 12px; border: 1px solid #e8edf3;
            padding: 18px; display: flex; align-items: flex-start; gap: 14px;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .stat-icon i { font-size: 22px; }
        .stat-label { font-size: 12px; color: #64748b; margin-bottom: 4px; }
        .stat-value { font-size: 26px; font-weight: 700; color: #0f172a; line-height: 1; }
        .stat-hint { font-size: 11px; color: #94a3b8; margin-top: 4px; }

        /* ── Buttons ──────────────────────────────────────────── */
        .btn { display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; border: none; transition: all 0.15s; }
        .btn-primary { background: #185FA5; color: #fff; }
        .btn-primary:hover { background: #145090; }
        .btn-secondary { background: #f1f5f9; color: #475569; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-success { background: #16a34a; color: #fff; }
        .btn-success:hover { background: #15803d; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ── Badges ───────────────────────────────────────────── */
        .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
        .badge-lost { background: #FCEBEB; color: #A32D2D; }
        .badge-found { background: #EAF3DE; color: #3B6D11; }
        .badge-high { background: #E6F1FB; color: #185FA5; }
        .badge-possible { background: #FAEEDA; color: #854F0B; }
        .badge-low { background: #f1f5f9; color: #64748b; }
        .badge-pending { background: #FAEEDA; color: #854F0B; }
        .badge-approved { background: #EAF3DE; color: #3B6D11; }
        .badge-rejected { background: #FCEBEB; color: #A32D2D; }
        .badge-active { background: #E6F1FB; color: #185FA5; }
        .badge-claimed { background: #EAF3DE; color: #3B6D11; }

        /* ── Forms ────────────────────────────────────────────── */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 9px 12px; border: 1px solid #d1d9e0;
            border-radius: 8px; font-size: 13px; color: #1e293b;
            background: #fff; transition: all 0.15s;
            font-family: 'Inter', sans-serif;
        }
        .form-input:focus { outline: none; border-color: #185FA5; box-shadow: 0 0 0 3px rgba(24,95,165,0.12); }
        .form-hint { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }

        /* ── Table ────────────────────────────────────────────── */
        .table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .table th { padding: 11px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; background: #f8fafc; border-bottom: 1px solid #e8edf3; }
        .table td { padding: 13px 16px; border-bottom: 1px solid #f1f5f9; color: #374151; }
        .table tbody tr:hover td { background: #f8fafc; }
        .table tbody tr:last-child td { border-bottom: none; }

        /* ── Alerts ───────────────────────────────────────────── */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert i { font-size: 18px; flex-shrink: 0; }

        /* ── Quick actions ────────────────────────────────────── */
        .action-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
        .action-card {
            background: #fff; border: 1px solid #e8edf3; border-radius: 12px;
            padding: 16px 18px; display: flex; align-items: center; gap: 14px;
            text-decoration: none; transition: all 0.2s; cursor: pointer;
        }
        .action-card:hover { border-color: #185FA5; box-shadow: 0 4px 16px rgba(24,95,165,0.1); transform: translateY(-1px); }
        .action-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .action-icon i { font-size: 21px; }
        .action-label { font-size: 13.5px; font-weight: 600; color: #1e293b; }
        .action-sub { font-size: 11.5px; color: #94a3b8; margin-top: 2px; }

        /* ── Misc ─────────────────────────────────────────────── */
        .empty-state { padding: 48px 24px; text-align: center; color: #94a3b8; }
        .empty-state i { font-size: 44px; display: block; margin-bottom: 12px; color: #cbd5e1; }
        .empty-state p { font-size: 14px; margin-bottom: 4px; color: #64748b; }
        .empty-state span { font-size: 12px; }
        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 0; }
        .text-muted { color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>

@auth
<!-- ── Sidebar ─────────────────────────────────────────────────── -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="ti ti-search"></i></div>
        <div>
            <div class="brand-name">Find<span>IT</span></div>
            <div class="brand-sub">CTU – Tuburan Campus</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        @if(auth()->user()->isAdmin())
            <div class="nav-section-label">Admin</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="ti ti-users"></i> Manage Users
            </a>
            <a href="{{ route('admin.items') }}" class="nav-item {{ request()->routeIs('admin.items') ? 'active' : '' }}">
                <i class="ti ti-package"></i> Manage Items
            </a>
            <a href="{{ route('admin.claims') }}" class="nav-item {{ request()->routeIs('admin.claims') ? 'active' : '' }}">
                <i class="ti ti-checklist"></i> Manage Claims
            </a>
            <a href="{{ route('admin.matches') }}" class="nav-item {{ request()->routeIs('admin.matches') ? 'active' : '' }}">
                <i class="ti ti-git-compare"></i> Match Results
            </a>
            <a href="{{ route('admin.admins.index') }}" class="nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="ti ti-shield-plus"></i> Manage Admins
            </a>
        @else
            <div class="nav-section-label">Menu</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('items.index') }}" class="nav-item {{ request()->routeIs('items.index') ? 'active' : '' }}">
                <i class="ti ti-package"></i> Browse Items
            </a>
            <a href="{{ route('items.create') }}" class="nav-item {{ request()->routeIs('items.create') ? 'active' : '' }}">
                <i class="ti ti-plus"></i> Report Item
            </a>
            <a href="{{ route('items.my') }}" class="nav-item {{ request()->routeIs('items.my') ? 'active' : '' }}">
                <i class="ti ti-bookmark"></i> My Items
            </a>
            <a href="{{ route('claims.my') }}" class="nav-item {{ request()->routeIs('claims.my') ? 'active' : '' }}">
                <i class="ti ti-checklist"></i> My Claims
            </a>
            <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <i class="ti ti-bell"></i> Notifications
                @php $unread = auth()->user()->customNotifications()->where('is_read', false)->count(); @endphp
                @if($unread > 0)
                    <span class="nav-badge">{{ $unread }}</span>
                @endif
            </a>
        @endif
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Sign out">
                <i class="ti ti-logout" style="font-size:17px;"></i>
            </button>
        </form>
    </div>
</div>

<!-- ── Main content ───────────────────────────────────────────── -->
<div class="main-content">
    <div class="topbar">
        <div class="topbar-left">
            @isset($header)
                {{ $header }}
            @endisset
        </div>
        <div class="topbar-right">
            @if(!auth()->user()->isAdmin())
                <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus"></i> Report Item
                </a>
            @endif
        </div>
    </div>
    <div class="page-body">
        {{ $slot }}
    </div>
</div>
@endauth

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>