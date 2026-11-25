<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Manage Claims</div>
            <div class="topbar-sub">Review and process claim requests.</div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display:flex;flex-direction:column;gap:14px;">
        @forelse($claims as $claim)
            <div class="card">
                <div style="padding:18px;">

                    {{-- Top Row: Claimer + Status + Actions --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:16px;">

                        {{-- Claimer Info --}}
                        <div>
                            <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;font-weight:600;">Claimed By</div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:38px;height:38px;border-radius:50%;background:#EBF3FC;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;color:#185FA5;flex-shrink:0;">
                                    {{ strtoupper(substr($claim->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-size:13.5px;font-weight:600;color:#1e293b;">{{ $claim->user->name }}</div>
                                    <div style="font-size:12px;color:#64748b;">{{ $claim->user->email }}</div>
                                    <div style="font-size:12px;color:#94a3b8;">ID: {{ $claim->user->id_number }}</div>
                                    <div style="font-size:12px;color:#94a3b8;">📞 {{ $claim->user->contact_number }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Match Score --}}
                        <div>
                            <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;font-weight:600;">Match Score</div>
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                <span style="font-size:28px;font-weight:800;color:{{ $claim->match->match_level === 'high' ? '#185FA5' : ($claim->match->match_level === 'possible' ? '#854F0B' : '#64748b') }};">
                                    {{ number_format($claim->match->total_score, 0) }}%
                                </span>
                                <span class="badge badge-{{ $claim->match->match_level }}">
                                    {{ strtoupper($claim->match->match_level) }}
                                </span>
                            </div>
                            <div style="background:#e2e8f0;border-radius:4px;height:5px;margin-bottom:8px;">
                                <div style="background:{{ $claim->match->match_level === 'high' ? '#185FA5' : ($claim->match->match_level === 'possible' ? '#f97316' : '#94a3b8') }};height:5px;border-radius:4px;width:{{ $claim->match->total_score }}%;"></div>
                            </div>
                            <div style="font-size:11px;color:#94a3b8;line-height:1.8;">
                                <div>📍 Location: <b style="color:#374151;">{{ $claim->match->location_score }}%</b></div>
                                <div>📅 Date/Time: <b style="color:#374151;">{{ $claim->match->date_time_score }}%</b></div>
                                <div>🏷️ Category: <b style="color:#374151;">{{ $claim->match->category_score }}%</b></div>
                            </div>
                        </div>

                        {{-- Status & Actions --}}
                        <div>
                            <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;font-weight:600;">Status & Actions</div>
                            <span class="badge badge-{{ $claim->status }}" style="font-size:12px;padding:5px 12px;margin-bottom:12px;display:inline-block;">
                                {{ strtoupper($claim->status) }}
                            </span>
                            @if($claim->status === 'pending')
                                <div style="display:flex;gap:8px;margin-top:8px;">
                                    <form method="POST" action="{{ route('admin.claims.approve', $claim) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="ti ti-check"></i> Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.claims.reject', $claim) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="ti ti-x"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div style="margin-top:10px;font-size:12px;color:#94a3b8;">
                                Submitted: {{ $claim->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                    {{-- Matched Items Details --}}
                    <div style="border-top:1px solid #f1f5f9;padding-top:16px;margin-bottom:16px;">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:12px;font-weight:600;">
                            <i class="ti ti-git-compare" style="font-size:13px;"></i> Matched Item Details
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">

                            {{-- Lost Item --}}
                            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:14px;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                                    <span class="badge badge-lost">LOST</span>
                                    <span style="font-size:13px;font-weight:600;color:#1e293b;">{{ $claim->match->lostItem->title }}</span>
                                </div>
                                @if($claim->match->lostItem->image)
                                    <img src="{{ Storage::url($claim->match->lostItem->image) }}"
                                        style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:10px;">
                                @endif
                                <div style="display:flex;flex-direction:column;gap:5px;">
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-tag" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->lostItem->category }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-map-pin" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->lostItem->location }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-calendar" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->lostItem->date_reported }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-clock" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->lostItem->time_reported }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-user" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->lostItem->user->name }}
                                    </div>
                                    @if($claim->match->lostItem->description)
                                        <div style="font-size:12px;color:#64748b;margin-top:4px;padding:8px;background:rgba(255,255,255,0.7);border-radius:6px;">
                                            {{ $claim->match->lostItem->description }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Found Item --}}
                            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                                    <span class="badge badge-found">FOUND</span>
                                    <span style="font-size:13px;font-weight:600;color:#1e293b;">{{ $claim->match->foundItem->title }}</span>
                                </div>
                                @if($claim->match->foundItem->image)
                                    <img src="{{ Storage::url($claim->match->foundItem->image) }}"
                                        style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:10px;">
                                @endif
                                <div style="display:flex;flex-direction:column;gap:5px;">
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-tag" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->foundItem->category }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-map-pin" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->foundItem->location }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-calendar" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->foundItem->date_reported }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-clock" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->foundItem->time_reported }}
                                    </div>
                                    <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                                        <i class="ti ti-user" style="font-size:12px;color:#94a3b8;"></i>
                                        {{ $claim->match->foundItem->user->name }}
                                    </div>
                                    @if($claim->match->foundItem->description)
                                        <div style="font-size:12px;color:#64748b;margin-top:4px;padding:8px;background:rgba(255,255,255,0.7);border-radius:6px;">
                                            {{ $claim->match->foundItem->description }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Proof of Ownership --}}
                    <div style="border-top:1px solid #f1f5f9;padding-top:14px;">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;font-weight:600;">
                            <i class="ti ti-shield-check" style="font-size:13px;"></i> Proof of Ownership
                        </div>
                        <div style="font-size:13px;color:#374151;line-height:1.6;background:#f8fafc;border-radius:8px;padding:12px;margin-bottom:10px;">
                            {{ $claim->proof_description }}
                        </div>
                        @if($claim->proof_image)
                            <div>
                                <div style="font-size:11px;color:#94a3b8;margin-bottom:6px;">Proof Image:</div>
                                <img src="{{ Storage::url($claim->proof_image) }}"
                                    style="height:140px;border-radius:8px;object-fit:cover;border:1px solid #e8edf3;">
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="card">
                <div class="empty-state">
                    <i class="ti ti-checklist"></i>
                    <p>No claim requests yet.</p>
                    <span>Claims will appear here once users submit them.</span>
                </div>
            </div>
        @endforelse
    </div>

    <div style="margin-top:16px;">{{ $claims->links('vendor.pagination.custom') }}</div>
</x-app-layout>