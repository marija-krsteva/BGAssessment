<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * update item quantity per user
     *
     * @param $quantity
     * @return void
     */
    public function saveItemQuantity($quantity) {
        $this->pivot->update(['quantity' => $quantity]);
    }

    /**
     * Relationships
     */
    public function exchanged() {
        return $this->belongsToMany('Item', 'exchanges', 'item_exchanged_into_id', 'item_exchanged_id')->withPivot('rate');
    }

    public function exchanged_into() {
        return $this->belongsToMany('Item', 'exchanges', 'item_exchanged_id', 'item_exchanged_into_id')->withPivot('rate');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'item_user', 'item_id', 'user_id')->withPivot('quantity');
    }

}
