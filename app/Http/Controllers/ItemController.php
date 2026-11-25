<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemMatch;
use App\Services\MatchService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected MatchService $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    public function index()
    {
        $query = Item::with('user')->where('status', 'active');

        if (request('type')) {
            $query->where('type', request('type'));
        }
        if (request('category')) {
            $query->where('category', request('category'));
        }
        if (request('location')) {
            $query->where('location', request('location'));
        }
        if (request('date')) {
            $query->where('date_reported', request('date'));
        }

        $items = $query->latest()->paginate(10)->withQueryString();
        return view('items.index', compact('items'));
    }
    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'          => ['required', 'in:lost,found'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'category'      => ['required', 'string'],
            'location'      => ['nullable', 'string'],
            'date_reported' => ['required', 'date'],
            'time_reported' => ['required'],
            'image'         => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'user_id'       => auth()->id(),
            'type'          => $request->type,
            'title'         => $request->title,
            'description'   => $request->description,
            'category'      => $request->category,
            'location'      => $request->location,
            'date_reported' => $request->date_reported,
            'time_reported' => $request->time_reported,
            'image'         => $imagePath,
            'status'        => 'active',
        ]);

        $this->matchService->findMatches($item);

        return redirect()->route('items.my')
            ->with('success', 'Item reported! We will notify you of any matches.');
    }

    public function show(Item $item)
    {
        $matches = ItemMatch::where('lost_item_id', $item->id)
            ->orWhere('found_item_id', $item->id)
            ->with(['lostItem', 'foundItem'])
            ->orderByDesc('total_score')
            ->get();

        return view('items.show', compact('item', 'matches'));
    }

    public function myItems()
    {
        $items = Item::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('items.my-items', compact('items'));
    }
}