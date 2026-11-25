<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'lost_item_id',
        'found_item_id',
        'location_score',
        'date_time_score',
        'category_score',
        'total_score', 
        'match_level',
        'status',
    ];

    public function lostItem()
    {
        return $this->belongsTo(Item::class, 'lost_item_id');
    }

    public function foundItem()
    {
        return $this->belongsTo(Item::class, 'found_item_id');
    }

    public function claimRequests()
    {
        return $this->hasMany(ClaimRequest::class, 'match_id');
    }
}