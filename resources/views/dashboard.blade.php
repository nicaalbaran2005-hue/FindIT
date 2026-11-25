<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Dashboard</div>
            <div class="topbar-sub">Welcome back, {{ auth()->user()->name }}!</div>
        </div>
    </x-slot>

    {{-- Stat Cards --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#EBF3FC;">
                <i class="ti ti-alert-circle" style="color:#185FA5;"></i>
            </div>
            <div>
                <div class="stat-label">Lost Items</div>
                <div class="stat-value">{{ auth()->user()->items()->where('type','lost')->count() }}</div>
                <div class="stat-hint">Reported by you</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EAF3DE;">
                <i class="ti ti-circle-check" style="color:#3B6D11;"></i>
            </div>
            <div>
                <div class="stat-label">Found Items</div>
                <div class="stat-value">{{ auth()->user()->items()->where('type','found')->count() }}</div>
                <div class="stat-hint">Reported by you</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EEEDFE;">
                <i class="ti ti-file-text" style="color:#534AB7;"></i>
            </div>
            <div>
                <div class="stat-label">My Claims</div>
                <div class="stat-value">{{ auth()->user()->claimRequests()->count() }}</div>
                <div class="stat-hint">Submitted claims</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FAEEDA;">
                <i class="ti ti-bell" style="color:#854F0B;"></i>
            </div>
            <div>
                <div class="stat-label">Notifications</div>
                <div class="stat-value">{{ auth()->user()->customNotifications()->where('is_read',false)->count() }}</div>
                <div class="stat-hint">Unread</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="action-grid">
        <a href="{{ route('items.create') }}" class="action-card">
            <div class="action-icon" style="background:#EBF3FC;">
                <i class="ti ti-plus" style="color:#185FA5;"></i>
            </div>
            <div>
                <div class="action-label">Report Item</div>
                <div class="action-sub">Report a lost or found item</div>
            </div>
        </a>
        <a href="{{ route('items.index') }}" class="action-card">
            <div class="action-icon" style="background:#E1F5EE;">
                <i class="ti ti-search" style="color:#0F6E56;"></i>
            </div>
            <div>
                <div class="action-label">Browse Items</div>
                <div class="action-sub">View all reported items</div>
            </div>
        </a>
        <a href="{{ route('notifications.index') }}" class="action-card">
            <div class="action-icon" style="background:#FAEEDA;">
                <i class="ti ti-bell" style="color:#854F0B;"></i>
            </div>
            <div>
                <div class="action-label">Notifications</div>
                <div class="action-sub">Check your updates</div>
            </div>
        </a>
    </div>

    {{-- Recent Items --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-clock"></i> Recent Items
            </div>
            <a href="{{ route('items.my') }}" class="btn btn-secondary btn-sm">
                View all
            </a>
        </div>
        @php $recentItems = auth()->user()->items()->latest()->take(5)->get(); @endphp
        @forelse($recentItems as $item)
            <div style="padding:13px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;background:#f1f5f9;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="ti ti-package" style="color:#94a3b8;font-size:19px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13.5px;font-weight:500;color:#1e293b;display:flex;align-items:center;gap:7px;">
                        {{ $item->title }}
                        <span class="badge badge-{{ $item->type }}">{{ strtoupper($item->type) }}</span>
                    </div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:2px;">
                        {{ $item->category }} &bull; {{ $item->location }} &bull; {{ $item->date_reported }}
                    </div>
                </div>
                <span class="badge badge-{{ $item->status }}">{{ strtoupper($item->status) }}</span>
                <a href="{{ route('items.show', $item) }}" class="btn btn-secondary btn-sm">
                    <i class="ti ti-eye"></i> View
                </a>
            </div>
        @empty
            <div class="empty-state">
                <i class="ti ti-package-off"></i>
                <p>No items reported yet.</p>
                <span>Start by reporting a lost or found item.</span>
            </div>
        @endforelse
    </div>
</x-app-layout>