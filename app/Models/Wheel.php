<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wheel extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'quantity'
    ];

    /**
     * Relationships
     */
    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function user() {
        return $this->belongsToMany(User::class);
    }
}
