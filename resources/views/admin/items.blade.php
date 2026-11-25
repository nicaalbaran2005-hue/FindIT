<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Manage Items</div>
            <div class="topbar-sub">All reported lost and found items.</div>
        </div>
    </x-slot>

    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-package"></i> All Items
            </div>
            <span class="text-muted">{{ $items->total() }} total</span>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Reported By</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td><span class="badge badge-{{ $item->type }}">{{ strtoupper($item->type) }}</span></td>
                        <td style="font-weight:500;color:#1e293b;">{{ $item->title }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->location }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:26px;height:26px;border-radius:50%;background:#EBF3FC;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:#185FA5;">
                                    {{ strtoupper(substr($item->user->name, 0, 2)) }}
                                </div>
                                <span style="font-size:12.5px;">{{ $item->user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $item->date_reported }}</td>
                        <td><span class="badge badge-{{ $item->status }}">{{ strtoupper($item->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="ti ti-package-off"></i>
                                <p>No items reported yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $items->links('vendor.pagination.custom') }}</div>
</x-app-layout>