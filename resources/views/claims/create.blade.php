<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Submit Claim Request</div>
            <div class="topbar-sub">Provide proof of ownership for this item.</div>
        </div>
    </x-slot>

    <div style="max-width:640px;margin:0 auto;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="ti ti-hand-finger"></i> Claim Request
                </div>
                <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm">
                    <i class="ti ti-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">

                {{-- Match Info --}}
                <div style="background:{{ $match->match_level === 'high' ? '#f0f7ff' : ($match->match_level === 'possible' ? '#fffbf5' : '#f8fafc') }};border:1px solid {{ $match->match_level === 'high' ? '#bfdbfe' : ($match->match_level === 'possible' ? '#fed7aa' : '#e8edf3') }};border-radius:10px;padding:16px;margin-bottom:20px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <span class="badge badge-{{ $match->match_level }}">{{ strtoupper($match->match_level) }} MATCH</span>
                        <span style="font-size:22px;font-weight:700;color:{{ $match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#854F0B' : '#64748b') }};">
                            {{ number_format($match->total_score, 0) }}%
                        </span>
                    </div>
                    <div style="font-size:13px;color:#374151;margin-bottom:4px;">
                        <strong>Lost:</strong> {{ $match->lostItem->title }}
                    </div>
                    <div style="font-size:13px;color:#374151;">
                        <strong>Found:</strong> {{ $match->foundItem->title }}
                    </div>
                    {{-- Score bar --}}
                    <div style="background:#e2e8f0;border-radius:4px;height:4px;margin-top:12px;">
                        <div style="background:{{ $match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#f97316' : '#94a3b8') }};height:4px;border-radius:4px;width:{{ $match->total_score }}%;"></div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="ti ti-alert-circle"></i>
                        <ul style="list-style:disc;padding-left:16px;">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('claims.store', $match) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Proof of Ownership <span style="color:#dc2626;">*</span></label>
                        <div class="form-hint" style="margin-bottom:8px;">Describe specific details only the owner would know (color, brand, contents, markings, etc.)</div>
                        <textarea name="proof_description" rows="5" class="form-input" required minlength="20" placeholder="e.g. My phone has a cracked screen on the bottom left corner, has a black case with my name written on the back...">{{ old('proof_description') }}</textarea>
                        <div class="form-hint">Minimum 20 characters required.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Proof Image <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <div style="border:2px dashed #d1d9e0;border-radius:10px;padding:20px;text-align:center;cursor:pointer;" onclick="document.getElementById('proof_image').click()">
                            <i class="ti ti-photo" style="font-size:28px;color:#94a3b8;display:block;margin-bottom:6px;"></i>
                            <p style="font-size:13px;color:#64748b;">Click to upload proof image</p>
                            <input type="file" id="proof_image" name="proof_image" accept="image/*" style="display:none;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:11px;">
                        <i class="ti ti-send"></i> Submit Claim Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>