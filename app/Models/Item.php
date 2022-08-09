<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
    ];

    public function exchanged() {
        return $this->belongsToMany('Item', 'exchanges', 'item_exchanged_id', 'item_exchanged_into_id');
    }

    public function exchanged_into() {
        return $this->belongsToMany('Item', 'exchanges', 'item_exchanged_into_id', 'item_exchanged_id');
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

}
