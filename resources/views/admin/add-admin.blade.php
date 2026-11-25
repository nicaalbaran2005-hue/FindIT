<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Add Admin</div>
            <div class="topbar-sub">Create a new administrator account.</div>
        </div>
    </x-slot>

    <div class="card" style="max-width:560px;">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-user-plus"></i> New Admin Account
            </div>
        </div>

        <div style="padding:20px;">
            @if (session('success'))
                <div style="background:#dcfce7;color:#166534;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:#fee2e2;color:#991b1b;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admins.store') }}">
                @csrf

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">
                        Contact Number <span class="text-muted">(optional)</span>
                    </label>
                    <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                           style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Password</label>
                    <input type="password" name="password" required
                           style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;">
                    <div class="text-muted" style="font-size:12px;margin-top:4px;">At least 8 characters.</div>
                </div>

                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           style="width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;">
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">
                    <i class="ti ti-user-plus"></i> Create Admin
                </button>
            </form>
        </div>
    </div>
</x-app-layout>