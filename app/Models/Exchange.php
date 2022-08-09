<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = [
        'item_exchanged_id',
        'item_exchanged_into_id',
        'rate',
    ];

    public function exchanged() {
        return $this->belongsToMany('Exchange', 'exchanges', 'item_exchanged_id', 'item_exchanged_into_id');
    }

    public function exchanged_in() {
        return $this->belongsToMany('Exchange', 'exchanges', 'item_exchanged_into_id', 'item_exchanged_id');
    }
}
