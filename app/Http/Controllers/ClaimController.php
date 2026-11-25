<?php

namespace App\Http\Controllers;

use App\Models\ClaimRequest;
use App\Models\Item;
use App\Models\ItemMatch;
use App\Models\AppNotification;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function create(ItemMatch $match)
    {
        return view('claims.create', compact('match'));
    }

    public function store(Request $request, ItemMatch $match)
    {
        $request->validate([
            'proof_description' => ['required', 'string', 'min:20'],
            'proof_image'       => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('proof_image')) {
            $imagePath = $request->file('proof_image')->store('claims', 'public');
        }

        $item = $match->lostItem->user_id === auth()->id()
            ? $match->lostItem
            : $match->foundItem;

        ClaimRequest::create([
            'user_id'           => auth()->id(),
            'item_id'           => $item->id,
            'match_id'          => $match->id,
            'proof_description' => $request->proof_description,
            'proof_image'       => $imagePath,
            'status'            => 'pending',
        ]);

        AppNotification::create([
            'user_id'      => auth()->id(),
            'title'        => 'Claim Submitted',
            'message'      => 'Your claim request has been submitted and is pending review.',
            'type'         => 'claim',
            'reference_id' => $match->id,
        ]);

        return redirect()->route('items.my')
            ->with('success', 'Claim request submitted! Wait for admin approval.');
    }

    public function myClams()
    {
        $claims = ClaimRequest::where('user_id', auth()->id())
            ->with(['item', 'match'])
            ->latest()
            ->paginate(10);
        return view('claims.my-claims', compact('claims'));
    }
}