<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Notifications</div>
            <div class="topbar-sub">Your system notifications and updates.</div>
        </div>
    </x-slot>

    <div style="max-width:700px;margin:0 auto;">
        <div class="card" style="overflow:hidden;">
            <div class="card-header">
                <div class="card-title">
                    <i class="ti ti-bell"></i> All Notifications
                </div>
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="ti ti-checks"></i> Mark All as Read
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="margin:14px 18px 0;">
                    <i class="ti ti-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            @forelse($notifications as $notif)
                <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;gap:14px;align-items:flex-start;{{ !$notif->is_read ? 'background:#f8fbff;border-left:3px solid #185FA5;' : '' }}">
                    <div style="width:38px;height:38px;border-radius:10px;background:{{ !$notif->is_read ? '#EBF3FC' : '#f1f5f9' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ti ti-bell" style="font-size:18px;color:{{ !$notif->is_read ? '#185FA5' : '#94a3b8' }};"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:13.5px;font-weight:{{ !$notif->is_read ? '600' : '500' }};color:#1e293b;">
                            {{ $notif->title }}
                        </div>
                        <div style="font-size:12.5px;color:#64748b;margin-top:3px;">{{ $notif->message }}</div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:4px;">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$notif->is_read)
                        <form method="POST" action="{{ route('notifications.read', $notif) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-secondary btn-sm">
                                <i class="ti ti-check"></i> Read
                            </button>
                        </form>
                    @else
                        <span style="font-size:11px;color:#94a3b8;white-space:nowrap;">Read</span>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="ti ti-bell-off"></i>
                    <p>No notifications yet.</p>
                    <span>You'll be notified when items match or claims are updated.</span>
                </div>
            @endforelse
        </div>
        <div style="margin-top:16px;">{{ $notifications->links('vendor.pagination.custom') }}</div>
    </div>
</x-app-layout>