<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Match Results</div>
            <div class="topbar-sub">All computed match scores between lost and found items.</div>
        </div>
    </x-slot>

    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-git-compare"></i> Match Results
            </div>
            <span class="text-muted">{{ $matches->total() }} total</span>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lost Item</th>
                    <th>Found Item</th>
                    <th>Location</th>
                    <th>Date/Time</th>
                    <th>Category</th>
                    <th>Total Score</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                @forelse($matches as $match)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ $match->lostItem->title }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $match->lostItem->user->name }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ $match->foundItem->title }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $match->foundItem->user->name }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $match->location_score }}%</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $match->date_time_score }}%</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;">{{ $match->category_score }}%</div>
                        </td>
                        <td>
                            <div style="font-size:16px;font-weight:700;color:{{ $match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#854F0B' : '#64748b') }};">
                                {{ number_format($match->total_score, 0) }}%
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $match->match_level }}">
                                {{ strtoupper($match->match_level) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="ti ti-git-compare"></i>
                                <p>No match results yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $matches->links('vendor.pagination.custom') }}</div>
</x-app-layout>