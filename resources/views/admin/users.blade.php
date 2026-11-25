<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Manage Users</div>
            <div class="topbar-sub">All registered students and staff.</div>
        </div>
    </x-slot>

    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-users"></i> Registered Users
            </div>
            <span class="text-muted">{{ $users->total() }} total</span>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Items</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:#EBF3FC;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#185FA5;flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span style="font-weight:500;color:#1e293b;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->id_number }}</td>
                        <td style="color:#64748b;">{{ $user->email }}</td>
                        <td>{{ $user->contact_number }}</td>
                        <td>
                            <span class="badge badge-active">{{ $user->items->count() }} items</span>
                        </td>
                        <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="ti ti-users-off"></i>
                                <p>No users registered yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $users->links('vendor.pagination.custom') }}</div>
</x-app-layout>