<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">My Items</div>
            <div class="topbar-sub">All items you have reported.</div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-bookmark"></i> Reported Items
            </div>
            <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                <i class="ti ti-plus"></i> Report Item
            </a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
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
                        <td class="text-muted">{{ $item->date_reported }}</td>
                        <td><span class="badge badge-{{ $item->status }}">{{ strtoupper($item->status) }}</span></td>
                        <td>
                            <a href="{{ route('items.show', $item) }}" class="btn btn-secondary btn-sm">
                                <i class="ti ti-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="ti ti-package-off"></i>
                                <p>No items reported yet.</p>
                                <span>Start by reporting a lost or found item.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $items->links('vendor.pagination.custom') }}</div>
</x-app-layout>