<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Item Details</div>
            <div class="topbar-sub">View item information and possible matches.</div>
        </div>
    </x-slot>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start;">

        {{-- Item Info --}}
        <div class="card" style="overflow:hidden;">
            @if($item->image)
                <img src="{{ Storage::url($item->image) }}" style="width:100%;height:230px;object-fit:cover;">
            @else
                <div style="height:180px;background:#f1f5f9;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                    <i class="ti ti-photo-off" style="font-size:40px;color:#cbd5e1;"></i>
                    <span style="font-size:12px;color:#cbd5e1;">No image uploaded</span>
                </div>
            @endif

            <div style="padding:20px;">
                <div style="display:flex;gap:6px;margin-bottom:12px;">
                    <span class="badge badge-{{ $item->type }}">{{ strtoupper($item->type) }}</span>
                    <span class="badge badge-{{ $item->status }}">{{ strtoupper($item->status) }}</span>
                </div>

                <h2 style="font-size:18px;font-weight:700;color:#0f172a;margin-bottom:16px;">{{ $item->title }}</h2>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Category</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ $item->category }}</div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Location</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ $item->location }}</div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Date</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ $item->date_reported }}</div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Time</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ $item->time_reported }}</div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Reported By</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ $item->user->name }}</div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Status</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;">{{ ucfirst($item->status) }}</div>
                    </div>
                </div>

                @if($item->description)
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Description</div>
                        <div style="font-size:13px;color:#374151;line-height:1.6;">{{ $item->description }}</div>
                    </div>
                @endif

                <div style="margin-top:16px;">
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Back to Items
                    </a>
                </div>
            </div>
        </div>

        {{-- Match Results --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="ti ti-git-compare"></i> Possible Matches
                </div>
                <span class="text-muted">{{ $matches->count() }} result(s)</span>
            </div>

            <div style="padding:14px;display:flex;flex-direction:column;gap:10px;">
                @forelse($matches as $match)
                    @php $other = $item->type === 'lost' ? $match->foundItem : $match->lostItem; @endphp

                    <div style="border:1px solid {{ $match->match_level === 'high' ? '#bfdbfe' : ($match->match_level === 'possible' ? '#fed7aa' : '#e8edf3') }};border-radius:10px;padding:14px;background:{{ $match->match_level === 'high' ? '#f0f7ff' : ($match->match_level === 'possible' ? '#fffbf5' : '#fafafa') }};">

                        <div style="display:flex;align-items:start;justify-content:space-between;margin-bottom:10px;">
                            <div style="flex:1;">
                                <span class="badge badge-{{ $match->match_level }}">{{ strtoupper($match->match_level) }} MATCH</span>
                                <div style="font-size:13.5px;font-weight:600;color:#1e293b;margin-top:8px;">{{ $other->title }}</div>
                                <div style="font-size:12px;color:#64748b;margin-top:3px;display:flex;align-items:center;gap:4px;">
                                    <i class="ti ti-tag" style="font-size:12px;"></i> {{ $other->category }}
                                    &bull;
                                    <i class="ti ti-map-pin" style="font-size:12px;"></i> {{ $other->location }}
                                </div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:2px;display:flex;align-items:center;gap:4px;">
                                    <i class="ti ti-calendar" style="font-size:11px;"></i> {{ $other->date_reported }}
                                </div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;margin-left:12px;">
                                <div style="font-size:26px;font-weight:700;color:{{ $match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#854F0B' : '#64748b') }};">
                                    {{ number_format($match->total_score, 0) }}%
                                </div>
                                <div style="font-size:10px;color:#94a3b8;margin-top:4px;text-align:right;line-height:1.6;">
                                    Location: {{ $match->location_score }}%<br>
                                    Date/Time: {{ $match->date_time_score }}%<br>
                                    Category: {{ $match->category_score }}%
                                </div>
                            </div>
                        </div>

                        {{-- Score Bar --}}
                        <div style="background:#e2e8f0;border-radius:4px;height:5px;margin-bottom:12px;">
                            <div style="background:{{ $match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#f97316' : '#94a3b8') }};height:5px;border-radius:4px;width:{{ $match->total_score }}%;"></div>
                        </div>

                        <div style="display:flex;gap:8px;">
                            <a href="{{ route('items.show', $other) }}" class="btn btn-secondary btn-sm">
                                <i class="ti ti-eye"></i> View
                            </a>

                            {{-- Hide the Claim button once either item has been claimed --}}
                            @if(
                                in_array($match->match_level, ['high', 'possible'])
                                && $item->user_id === auth()->id()
                                && strtolower($item->status) !== 'claimed'
                                && strtolower($other->status) !== 'claimed'
                            )
                                <a href="{{ route('claims.create', $match) }}" class="btn btn-primary btn-sm">
                                    <i class="ti ti-hand-finger"></i> Claim This Item
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="ti ti-git-compare"></i>
                        <p>No matches found yet.</p>
                        <span>Matches appear when similar items are reported.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>