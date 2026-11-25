<?php

namespace App\Http\Controllers;

use App\Models\ClaimRequest;
use App\Models\Item;
use App\Models\ItemMatch;
use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers    = User::where('role', 'user')->count();
        $totalItems    = Item::count();
        $totalLost     = Item::where('type', 'lost')->count();
        $totalFound    = Item::where('type', 'found')->count();
        $pendingClaims = ClaimRequest::where('status', 'pending')->count();
        $highMatches   = ItemMatch::where('match_level', 'high')->count();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalItems', 'totalLost',
            'totalFound', 'pendingClaims', 'highMatches'
        ));
    }

    public function users()
    {
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    // Show the "Add Admin" form
    public function createAdmin()
    {
        return view('admin.add-admin');
    }

    // Save the new admin account
    public function storeAdmin(Request $request)
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'password'       => ['required', 'confirmed', Password::min(8)],
        ]);

        // Set fields one by one so the role can never come from the form
        $user = new User();
        $user->name           = $data['name'];
        $user->email          = $data['email'];
        $user->contact_number = $data['contact_number'] ?? null;
        $user->password       = Hash::make($data['password']);
        $user->role           = 'admin';
        $user->save();

        return back()->with('success', 'Admin account created for ' . $user->email . '.');
    }

    public function items()
    {
        $items = Item::with('user')->latest()->paginate(10);
        return view('admin.items', compact('items'));
    }

    public function claims()
    {
        $claims = ClaimRequest::with(['user', 'item', 'match'])
            ->latest()->paginate(10);
        return view('admin.claims', compact('claims'));
    }

    public function approveClaim(ClaimRequest $claim)
    {
        $claim->update(['status' => 'approved']);
        $claim->item->update(['status' => 'claimed']);

        // Tell the owner (the person who lost the item)
        AppNotification::create([
            'user_id'      => $claim->user_id,
            'title'        => 'Claim Approved!',
            'message'      => 'Your claim for "' . $claim->item->title . '" has been approved! please go to the SAO office to claim your item.',
            'type'         => 'claim_approved',
            'reference_id' => $claim->id,
        ]);

        // Tell the finder, and close the found report
        $match = $claim->match;

        if ($match && $match->foundItem) {
            $found = $match->foundItem;

            AppNotification::create([
                'user_id'      => $found->user_id,
                'title'        => 'Item Claimed',
                'message'      => 'The item you found "' . $found->title . '" was claimed by its owner.',
                'type'         => 'claim_approved_finder',
                'reference_id' => $claim->id,
            ]);

            // Remove the found item from Browse Items
            $found->update(['status' => 'claimed']);
        }

        return back()->with('success', 'Claim approved successfully!');
    }

    public function rejectClaim(ClaimRequest $claim)
    {
        $claim->update(['status' => 'rejected']);

        AppNotification::create([
            'user_id'      => $claim->user_id,
            'title'        => 'Claim Rejected',
            'message'      => 'Your claim for "' . $claim->item->title . '" has been rejected.',
            'type'         => 'claim_rejected',
            'reference_id' => $claim->id,
        ]);

        return back()->with('success', 'Claim rejected.');
    }

    public function matches()
    {
        $matches = ItemMatch::with(['lostItem', 'foundItem'])
            ->orderByDesc('total_score')
            ->paginate(10);
        return view('admin.matches', compact('matches'));
    }
}