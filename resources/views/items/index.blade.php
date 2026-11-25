<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Browse Items</div>
            <div class="topbar-sub">All reported lost and found items on campus.</div>
        </div>
    </x-slot>

    {{-- Filter Bar --}}
    <div class="card" style="margin-bottom:16px;">
        <div class="card-body" style="padding:14px 18px;">
            <form method="GET" action="{{ route('items.index') }}">
                <div style="display:grid;grid-template-columns:repeat(4,1fr) auto auto;gap:10px;align-items:end;">
                    <div>
                        <label class="form-label">Type</label>
                        <select name="type" class="form-input">
                            <option value="">All Types</option>
                            <option value="lost" {{ request('type')=='lost' ? 'selected' : '' }}>🔴 Lost</option>
                            <option value="found" {{ request('type')=='found' ? 'selected' : '' }}>🟢 Found</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Category</label>
                        <select name="category" class="form-input">
                            <option value="">All Categories</option>
                            <option value="ID/Cards" {{ request('category')=='ID/Cards' ? 'selected' : '' }}>ID / Cards</option>
                            <option value="Electronics" {{ request('category')=='Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Bag/Wallet" {{ request('category')=='Bag/Wallet' ? 'selected' : '' }}>Bag / Wallet</option>
                            <option value="Clothing" {{ request('category')=='Clothing' ? 'selected' : '' }}>Clothing</option>
                            <option value="Keys" {{ request('category')=='Keys' ? 'selected' : '' }}>Keys</option>
                            <option value="Books/Documents" {{ request('category')=='Books/Documents' ? 'selected' : '' }}>Books / Documents</option>
                            <option value="Jewelry" {{ request('category')=='Jewelry' ? 'selected' : '' }}>Jewelry</option>
                            <option value="Others" {{ request('category')=='Others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Location</label>
                        <select name="location" class="form-input">
                            <option value="">All Locations</option>
                            <optgroup label="Zone A — Academic Core">
                                <option value="TB1">TB1</option>
                                <option value="TB2">TB2</option>
                                <option value="TB3">TB3</option>
                                <option value="TB4">TB4</option>
                                <option value="ASB1">ASB1</option>
                                <option value="ASMB">ASMB</option>
                                <option value="ASB2">ASB2</option>
                                <option value="Library">Library</option>
                                <option value="CAS">CAS</option>
                                <option value="COT">COT</option>
                                <option value="COED">COED</option>
                                <option value="Speech Communication Lab">Speech Communication Lab</option>
                                <option value="Math Lab">Math Lab</option>
                                <option value="ICT Lab">ICT Lab</option>
                            </optgroup>
                            <optgroup label="Zone B — Admin & Services">
                                <option value="Administration Building">Administration Building</option>
                                <option value="SSFB">SSFB</option>
                                <option value="HMB">HMB</option>
                                <option value="SAC">SAC</option>
                                <option value="Cafeteria">Cafeteria</option>
                                <option value="FIC">FIC</option>
                                <option value="FabLab">FabLab</option>
                                <option value="Guidance Office">Guidance Office</option>
                                <option value="SSC">SSC</option>
                                <option value="Cashier">Cashier</option>
                                <option value="Registrar">Registrar</option>
                            </optgroup>
                            <optgroup label="Zone C — Dormitory">
                                <option value="Men's Dormitory">Men's Dormitory</option>
                                <option value="Women's Dormitory">Women's Dormitory</option>
                                <option value="Hometel">Hometel</option>
                                <option value="GAD & Pasalubong Center">GAD & Pasalubong Center</option>
                            </optgroup>
                            <optgroup label="Zone D — Entrance & Parking">
                                <option value="Gate / Entrance">Gate / Entrance</option>
                                <option value="Gate / Exit">Gate / Exit</option>
                                <option value="Parking Area">Parking Area</option>
                                <option value="Security Office">Security Office</option>
                                <option value="Bulawanong Tinubdan Cultural Center">Bulawanong Tinubdan Cultural Center</option>
                            </optgroup>
                            <optgroup label="Zone E — Science & Engineering">
                                <option value="Science Building">Science Building</option>
                                <option value="Engineering Building">Engineering Building</option>
                                <option value="Animal Science Building">Animal Science Building</option>
                            </optgroup>
                            <optgroup label="Zone F — Agricultural">
                                <option value="Farmers Training Center">Farmers Training Center</option>
                                <option value="COAgri">COAgri</option>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Date</label>
                        <input type="date" name="date" value="{{ request('date') }}" class="form-input">
                    </div>
                    <div style="padding-top:20px;">
                        <button type="submit" class="btn btn-primary" style="width:100%;">
                            <i class="ti ti-filter"></i> Filter
                        </button>
                    </div>
                    <div style="padding-top:20px;">
                        <a href="{{ route('items.index') }}" class="btn btn-secondary" style="width:100%;justify-content:center;">
                            <i class="ti ti-x"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Items Grid --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        @forelse($items as $item)
            <div class="card" style="overflow:hidden;transition:all 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" style="width:100%;height:170px;object-fit:cover;">
                @else
                    <div style="height:170px;background:#f1f5f9;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;">
                        <i class="ti ti-photo-off" style="font-size:32px;color:#cbd5e1;"></i>
                        <span style="font-size:11px;color:#cbd5e1;">No image</span>
                    </div>
                @endif
                <div style="padding:14px 16px;">
                    <div style="display:flex;gap:6px;margin-bottom:10px;">
                        <span class="badge badge-{{ $item->type }}">{{ strtoupper($item->type) }}</span>
                        <span class="badge badge-{{ $item->status }}">{{ strtoupper($item->status) }}</span>
                    </div>
                    <div style="font-size:14px;font-weight:600;color:#1e293b;margin-bottom:8px;">{{ $item->title }}</div>
                    <div style="display:flex;flex-direction:column;gap:4px;margin-bottom:14px;">
                        <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                            <i class="ti ti-tag" style="font-size:13px;color:#94a3b8;"></i> {{ $item->category }}
                        </div>
                        <div style="font-size:12px;color:#64748b;display:flex;align-items:center;gap:5px;">
                            <i class="ti ti-map-pin" style="font-size:13px;color:#94a3b8;"></i> {{ $item->location }}
                        </div>
                        <div style="font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:5px;">
                            <i class="ti ti-calendar" style="font-size:13px;color:#94a3b8;"></i> {{ $item->date_reported }}
                        </div>
                    </div>
                    <a href="{{ route('items.show', $item) }}" class="btn btn-primary" style="width:100%;justify-content:center;">
                        <i class="ti ti-eye"></i> View Details
                    </a>
                </div>
            </div>
        @empty
            <div style="grid-column:span 3;">
                <div class="card">
                    <div class="empty-state">
                        <i class="ti ti-package-off"></i>
                        <p>No items found.</p>
                        <span>Try adjusting your filters or report a new item.</span>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div style="margin-top:16px;">{{ $items->links('vendor.pagination.custom') }}</div>
</x-app-layout>