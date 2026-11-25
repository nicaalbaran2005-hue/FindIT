<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">My Claims</div>
            <div class="topbar-sub">Track your claim request status.</div>
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
                <i class="ti ti-checklist"></i> Claim Requests
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Match Score</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Admin Remarks</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($claims as $claim)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td style="font-weight:500;color:#1e293b;">{{ $claim->item->title }}</td>
                        <td>
                            <span style="font-weight:600;color:{{ $claim->match->match_level === 'high' ? '#185FA5' : ($claim->match->match_level === 'possible' ? '#854F0B' : '#64748b') }};">
                                {{ number_format($claim->match->total_score, 0) }}%
                            </span>
                            <span class="badge badge-{{ $claim->match->match_level }}" style="margin-left:4px;">
                                {{ $claim->match->match_level }}
                            </span>
                        </td>
                        <td style="max-width:180px;">
                            <div style="font-size:12px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $claim->proof_description }}
                            </div>
                        </td>
                        <td><span class="badge badge-{{ $claim->status }}">{{ strtoupper($claim->status) }}</span></td>
                        <td style="font-size:12px;color:#64748b;">{{ $claim->admin_remarks ?? '—' }}</td>
                        <td class="text-muted">{{ $claim->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="ti ti-checklist"></i>
                                <p>No claim requests yet.</p>
                                <span>Claims appear when you request an item.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $claims->links('vendor.pagination.custom') }}</div>
</x-app-layout>