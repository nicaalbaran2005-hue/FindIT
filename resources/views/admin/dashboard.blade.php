<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Admin Dashboard</div>
            <div class="topbar-sub">System overview — CTU Tuburan Campus</div>
        </div>
    </x-slot>

    {{-- Stat Cards --}}
    <div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
        <div class="stat-card">
            <div class="stat-icon" style="background:#EBF3FC;">
                <i class="ti ti-users" style="color:#185FA5;"></i>
            </div>
            <div>
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-hint">Registered students & staff</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FCEBEB;">
                <i class="ti ti-alert-circle" style="color:#A32D2D;"></i>
            </div>
            <div>
                <div class="stat-label">Lost Items</div>
                <div class="stat-value">{{ $totalLost }}</div>
                <div class="stat-hint">Active reports</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EAF3DE;">
                <i class="ti ti-circle-check" style="color:#3B6D11;"></i>
            </div>
            <div>
                <div class="stat-label">Found Items</div>
                <div class="stat-value">{{ $totalFound }}</div>
                <div class="stat-hint">Active reports</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EEEDFE;">
                <i class="ti ti-package" style="color:#534AB7;"></i>
            </div>
            <div>
                <div class="stat-label">Total Items</div>
                <div class="stat-value">{{ $totalItems }}</div>
                <div class="stat-hint">All reported items</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FAEEDA;">
                <i class="ti ti-clock" style="color:#854F0B;"></i>
            </div>
            <div>
                <div class="stat-label">Pending Claims</div>
                <div class="stat-value">{{ $pendingClaims }}</div>
                <div class="stat-hint">Awaiting review</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#E1F5EE;">
                <i class="ti ti-git-compare" style="color:#0F6E56;"></i>
            </div>
            <div>
                <div class="stat-label">High Matches</div>
                <div class="stat-value">{{ $highMatches }}</div>
                <div class="stat-hint">Score >= 70%</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="action-grid" style="grid-template-columns:repeat(4,1fr);">
        <a href="{{ route('admin.users') }}" class="action-card">
            <div class="action-icon" style="background:#EBF3FC;">
                <i class="ti ti-users" style="color:#185FA5;"></i>
            </div>
            <div>
                <div class="action-label">Users</div>
                <div class="action-sub">{{ $totalUsers }} registered</div>
            </div>
        </a>
        <a href="{{ route('admin.items') }}" class="action-card">
            <div class="action-icon" style="background:#EEEDFE;">
                <i class="ti ti-package" style="color:#534AB7;"></i>
            </div>
            <div>
                <div class="action-label">Items</div>
                <div class="action-sub">{{ $totalItems }} total</div>
            </div>
        </a>
        <a href="{{ route('admin.claims') }}" class="action-card">
            <div class="action-icon" style="background:#FAEEDA;">
                <i class="ti ti-checklist" style="color:#854F0B;"></i>
            </div>
            <div>
                <div class="action-label">Claims</div>
                <div class="action-sub">{{ $pendingClaims }} pending</div>
            </div>
        </a>
        <a href="{{ route('admin.matches') }}" class="action-card">
            <div class="action-icon" style="background:#E1F5EE;">
                <i class="ti ti-git-compare" style="color:#0F6E56;"></i>
            </div>
            <div>
                <div class="action-label">Matches</div>
                <div class="action-sub">{{ $highMatches }} high</div>
            </div>
        </a>
    </div>
</x-app-layout>