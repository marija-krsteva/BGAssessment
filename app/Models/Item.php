<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Save item quantity per user
     *
     * @param $quantity
     * @return void
     */
    public function saveItemQuantity($user_id,$quantity) {
        $this->users()->attach($user_id,['quantity' => $quantity]);
    }

    /**
     * Update item quantity per user
     *
     * @param $quantity
     * @return void
     */
    public function updateItemQuantity($quantity) {

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

    public function wheels() {
        return $this->hasMany(Wheel::class);
    }

}
