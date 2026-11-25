<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="topbar-title">Manage Admins</div>
            <div class="topbar-sub">Add and view administrator accounts</div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="ti ti-alert-circle"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <div style="display:grid; grid-template-columns: 1fr 1.4fr; gap:20px; align-items:start;">

        {{-- Add Admin form --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="ti ti-shield-plus"></i> Add New Admin</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.admins.store') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="id_number">ID Number</label>
                        <input class="form-input" type="text" id="id_number" name="id_number" value="{{ old('id_number') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact_number">Contact Number</label>
                        <input class="form-input" type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group" x-data="{ show: false }">
                        <label class="form-label" for="password">Password</label>
                        <div style="position:relative;">
                            <input class="form-input" :type="show ? 'text' : 'password'"
                                   id="password" name="password" required style="padding-right:40px;">
                            <button type="button" @click="show = !show"
                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                           background:none; border:none; cursor:pointer; color:#94a3b8;"
                                    title="Show/Hide password">
                                <i class="ti" :class="show ? 'ti-eye-off' : 'ti-eye'" style="font-size:18px;"></i>
                            </button>
                        </div>
                        <div class="form-hint">Minimum of 8 characters.</div>
                    </div>

                    <div class="form-group" x-data="{ show: false }">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <div style="position:relative;">
                            <input class="form-input" :type="show ? 'text' : 'password'"
                                   id="password_confirmation" name="password_confirmation" required style="padding-right:40px;">
                            <button type="button" @click="show = !show"
                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                           background:none; border:none; cursor:pointer; color:#94a3b8;"
                                    title="Show/Hide password">
                                <i class="ti" :class="show ? 'ti-eye-off' : 'ti-eye'" style="font-size:18px;"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Add Admin
                    </button>
                </form>
            </div>
        </div>

        {{-- Current admins --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="ti ti-users"></i> Current Admins</div>
                <span class="badge badge-high">{{ $admins->count() }}</span>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>ID Number</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->id_number ?? '—' }}</td>
                            <td>{{ $admin->created_at?->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="ti ti-users"></i>
                                    <p>No admin found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>