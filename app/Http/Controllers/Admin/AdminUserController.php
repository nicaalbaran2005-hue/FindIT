<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'id_number'      => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User();
        $user->name           = $data['name'];
        $user->id_number      = $data['id_number'] ?? null;
        $user->contact_number = $data['contact_number'] ?? null;
        $user->email          = $data['email'];
        $user->password       = Hash::make($data['password']);
        $user->role           = 'admin';
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('admin.admins.index')
            ->with('success', 'New admin created successfully.');
    }
}