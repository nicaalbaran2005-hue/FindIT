<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Report an Item</div>
            <div class="topbar-sub">Fill in the details of the lost or found item.</div>
        </div>
    </x-slot>

    <div style="max-width:680px;margin:0 auto;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="ti ti-forms"></i> Item Report Form
                </div>
                <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm">
                    <i class="ti ti-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-error" style="margin-bottom:16px;">
                        <i class="ti ti-alert-circle"></i>
                        <div>
                            <div style="font-weight:500;margin-bottom:4px;">Please fix the following:</div>
                            <ul style="list-style:disc;padding-left:16px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Type --}}
                    <div class="form-group">
                        <label class="form-label">Item Type <span style="color:#dc2626;">*</span></label>
                        <select name="type" class="form-input" required>
                            <option value="">-- Select Type --</option>
                            <option value="lost" {{ old('type')=='lost' ? 'selected' : '' }}>🔴 Lost Item</option>
                            <option value="found" {{ old('type')=='found' ? 'selected' : '' }}>🟢 Found Item</option>
                        </select>
                    </div>

                    {{-- Category --}}
                    <div class="form-group">
                        <label class="form-label">Category <span style="color:#dc2626;">*</span></label>
                        <select name="category" id="category" onchange="updateSubcategory()" class="form-input" required>
                            <option value="">-- Select Category --</option>
                            <option value="ID/Cards">ID / Cards</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Bag/Wallet">Bag / Wallet</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Keys">Keys</option>
                            <option value="Books/Documents">Books / Documents</option>
                            <option value="Jewelry">Jewelry</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    {{-- Subcategory --}}
                    <div class="form-group" id="subcategory_div" style="display:none;">
                        <label class="form-label">Item Type <span style="color:#dc2626;">*</span></label>
                        <select id="subcategory" onchange="updateBrand2()" class="form-input">
                            <option value="">-- Select Item Type --</option>
                        </select>
                    </div>

                    {{-- Brand --}}
                    <div class="form-group" id="brand_div" style="display:none;">
                        <label class="form-label">Brand <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <select id="brand" onchange="updateBrand()" class="form-input">
                            <option value="">-- Select Brand (optional) --</option>
                        </select>
                        {{-- Manual input if Others --}}
                        <div id="brand_manual_div" style="display:none;margin-top:8px;">
                            <input type="text" id="brand_manual"
                                class="form-input"
                                placeholder="Type brand name..."
                                oninput="updateTitleManual()">
                            <div class="form-hint">Type the brand name if not in the list.</div>
                        </div>
                    </div>

                    <input type="hidden" name="title" id="title_hidden" value="{{ old('title') }}">

                    {{-- Location --}}
                    <div class="form-group">
                        <label class="form-label">Location <span style="color:#dc2626;">*</span></label>

                        {{-- FIX: this select no longer has name="location".
                             Only the hidden input below is submitted, so there is no duplicate field. --}}
                        <select id="location" class="form-input" required onchange="checkOtherLocation()">
                            <option value="">-- Select Location --</option>
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
                                <option value="Exit Gate">Exit Gate</option>
                                <option value="Parking Area">Parking Area</option>
                                <option value="Security Office">Security Office</option>
                                <option value="Basketball Court">Basketball Court</option>
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
                            <optgroup label="Others">
                                <option value="Others">Others (specify below)</option>
                            </optgroup>
                        </select>

                        {{-- Manual location input (not submitted by itself) --}}
                        <div id="location_manual_div" style="display:none;margin-top:8px;">
                            <input type="text" id="location_manual"
                                class="form-input"
                                placeholder="Type specific location..."
                                oninput="updateLocationValue()">
                            <div class="form-hint">Type the specific location if not in the list.</div>
                        </div>

                        {{-- The only field named "location" that is submitted --}}
                        <input type="hidden" name="location" id="location_hidden" value="{{ old('location') }}">

                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    {{-- Date & Time --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div class="form-group">
                            <label class="form-label">Date <span style="color:#dc2626;">*</span></label>
                            <input type="date" name="date_reported" class="form-input" value="{{ old('date_reported') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Time <span style="color:#dc2626;">*</span></label>
                            <input type="time" name="time_reported" class="form-input" value="{{ old('time_reported') }}" required>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label">Description <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <textarea name="description" rows="3" class="form-input" placeholder="Add more details about the item...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Image Upload --}}
                    <div class="form-group">
                        <label class="form-label">Upload Image <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                        <div style="border:2px dashed #d1d9e0;border-radius:10px;padding:24px;text-align:center;cursor:pointer;transition:all 0.15s;" onclick="document.getElementById('image').click()" onmouseover="this.style.borderColor='#185FA5';this.style.background='#f0f7ff'" onmouseout="this.style.borderColor='#d1d9e0';this.style.background='transparent'">
                            <i class="ti ti-cloud-upload" style="font-size:32px;color:#94a3b8;display:block;margin-bottom:8px;"></i>
                            <p style="font-size:13px;color:#64748b;font-weight:500;">Click to upload image</p>
                            <p style="font-size:11px;color:#94a3b8;margin-top:4px;">PNG, JPG up to 2MB</p>
                            <input type="file" id="image" name="image" accept="image/*" style="display:none;" onchange="previewImage(this)">
                        </div>
                        <div id="preview_div" style="display:none;margin-top:12px;">
                            <img id="preview_img" style="width:100%;height:180px;object-fit:cover;border-radius:10px;border:1px solid #e8edf3;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:11px;">
                        <i class="ti ti-send"></i> Submit Report
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function checkOtherLocation() {
            const locationSel = document.getElementById('location');
            const manualDiv = document.getElementById('location_manual_div');
            const manualInput = document.getElementById('location_manual');
            const hiddenInput = document.getElementById('location_hidden');

            if (locationSel.value === 'Others') {
                manualDiv.style.display = 'block';
                manualInput.value = '';
                hiddenInput.value = '';
                manualInput.focus();
            } else {
                manualDiv.style.display = 'none';
                manualInput.value = '';
                hiddenInput.value = locationSel.value;
            }
        }

        function updateLocationValue() {
            const manualInput = document.getElementById('location_manual');
            const hiddenInput = document.getElementById('location_hidden');
            hiddenInput.value = manualInput.value.trim();
        }

        const subcategories = {
            'Electronics': {
                'Phone': ['Samsung', 'iPhone/Apple', 'Xiaomi', 'OPPO', 'Vivo', 'Realme', 'Huawei', 'Nokia', 'Others'],
                'Laptop': ['Acer', 'Asus', 'Dell', 'HP', 'Lenovo', 'Apple MacBook', 'MSI', 'Others'],
                'Tablet': ['iPad/Apple', 'Samsung Tab', 'Huawei Tab', 'Lenovo Tab', 'Others'],
                'Earphones/Airpods': ['Apple AirPods', 'Samsung Buds', 'JBL', 'Sony', 'Xiaomi', 'Others'],
                'Charger': ['iPhone Charger', 'Android Charger', 'Laptop Charger', 'Others'],
                'Power Bank': ['Anker', 'Xiaomi', 'Samsung', 'Romoss', 'Others'],
                'USB/Flash Drive': ['Kingston', 'SanDisk', 'Toshiba', 'Others'],
                'Calculator': ['Casio', 'Sharp', 'Others'],
                'Camera': ['Canon', 'Nikon', 'Sony', 'Fujifilm', 'GoPro', 'Others'],
                'Smartwatch': ['Apple Watch', 'Samsung Watch', 'Xiaomi', 'Fitbit', 'Others'],
                'Others': ['Others']
            },
            'ID/Cards': {
                'School ID': ['CTU ID', 'Others'],
                'Government ID': ['SSS', 'PhilHealth', 'UMID', 'Postal ID', 'Voter ID', 'Others'],
                'ATM Card': ['BDO', 'BPI', 'Metrobank', 'Landbank', 'UnionBank', 'Others'],
                'Library Card': ['CTU Library', 'Others'],
                'Driver License': ['LTO License', 'Others'],
                'Passport': ['Philippine Passport', 'Others'],
                'Others': ['Others']
            },
            'Bag/Wallet': {
                'Backpack': ['Jansport', 'Nike', 'Adidas', 'Converse', 'Others'],
                'Handbag': ['Generic', 'Others'],
                'Wallet': ['Generic Leather', 'Generic Cloth', 'Others'],
                'Pouch': ['Generic', 'Others'],
                'Sling Bag': ['Generic', 'Others'],
                'Tote Bag': ['Generic', 'Others'],
                'Others': ['Others']
            },
            'Clothing': {
                'Jacket': ['Generic', 'Nike', 'Adidas', 'Others'],
                'Uniform': ['CTU Uniform', 'Others'],
                'T-Shirt': ['Generic', 'Others'],
                'Pants': ['Generic', 'Others'],
                'Shoes': ['Nike', 'Adidas', 'Vans', 'Converse', 'Others'],
                'Cap/Hat': ['Generic', 'Others'],
                'Umbrella': ['Generic', 'Others'],
                'Others': ['Others']
            },
            'Keys': {
                'House Key': ['Generic', 'Others'],
                'Car Key': ['Toyota', 'Honda', 'Mitsubishi', 'Suzuki', 'Others'],
                'Motorcycle Key': ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki', 'Others'],
                'Padlock Key': ['Generic', 'Others'],
                'Others': ['Others']
            },
            'Books/Documents': {
                'Textbook': ['Generic', 'Others'],
                'Notebook': ['Generic', 'Others'],
                'Certificate': ['Generic', 'Others'],
                'Printed Document': ['Generic', 'Others'],
                'Others': ['Others']
            },
            'Jewelry': {
                'Ring': ['Generic', 'Others'],
                'Necklace': ['Generic', 'Others'],
                'Bracelet': ['Generic', 'Others'],
                'Earrings': ['Generic', 'Others'],
                'Watch': ['Casio', 'Seiko', 'Generic', 'Others'],
                'Others': ['Others']
            },
            'Others': { 'Others': ['Others'] }
        };

        function updateSubcategory() {
            const cat = document.getElementById('category').value;
            const subDiv = document.getElementById('subcategory_div');
            const subSel = document.getElementById('subcategory');
            const brandDiv = document.getElementById('brand_div');
            const brandSel = document.getElementById('brand');
            const manualDiv = document.getElementById('brand_manual_div');
            const manualInput = document.getElementById('brand_manual');

            subSel.innerHTML = '<option value="">-- Select Item Type --</option>';
            brandSel.innerHTML = '<option value="">-- Select Brand (optional) --</option>';
            brandDiv.style.display = 'none';
            manualDiv.style.display = 'none';
            manualInput.value = '';
            document.getElementById('title_hidden').value = '';

            if (cat && subcategories[cat]) {
                Object.keys(subcategories[cat]).forEach(i => {
                    subSel.innerHTML += `<option value="${i}">${i}</option>`;
                });
                subDiv.style.display = 'block';
            } else {
                subDiv.style.display = 'none';
            }
        }

        function updateBrand2() {
            const cat = document.getElementById('category').value;
            const sub = document.getElementById('subcategory').value;
            const brandDiv = document.getElementById('brand_div');
            const brandSel = document.getElementById('brand');
            const manualDiv = document.getElementById('brand_manual_div');
            const manualInput = document.getElementById('brand_manual');

            brandSel.innerHTML = '<option value="">-- Select Brand (optional) --</option>';
            manualDiv.style.display = 'none';
            manualInput.value = '';

            if (cat && sub && subcategories[cat] && subcategories[cat][sub]) {
                subcategories[cat][sub].forEach(b => {
                    brandSel.innerHTML += `<option value="${b}">${b}</option>`;
                });
                brandDiv.style.display = 'block';
            } else {
                brandDiv.style.display = 'none';
            }
            updateTitle();
        }

        function updateBrand() {
            const brandVal = document.getElementById('brand').value;
            const manualDiv = document.getElementById('brand_manual_div');
            const manualInput = document.getElementById('brand_manual');

            if (brandVal === 'Others') {
                manualDiv.style.display = 'block';
                manualInput.value = '';
                manualInput.focus();
                document.getElementById('title_hidden').value = '';
            } else {
                manualDiv.style.display = 'none';
                manualInput.value = '';
                updateTitle();
            }
        }

        function updateTitleManual() {
            const sub = document.getElementById('subcategory').value;
            const manualVal = document.getElementById('brand_manual').value;
            const title = document.getElementById('title_hidden');

            if (manualVal.trim() !== '') {
                title.value = manualVal.trim() + ' ' + sub;
            } else {
                title.value = sub;
            }
        }

        function updateTitle() {
            const sub = document.getElementById('subcategory').value;
            const brand = document.getElementById('brand').value;
            const title = document.getElementById('title_hidden');

            if (brand && brand !== '' && brand !== 'Others') {
                title.value = brand + ' ' + sub;
            } else if (sub) {
                title.value = sub;
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('preview_img').src = e.target.result;
                    document.getElementById('preview_div').style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>