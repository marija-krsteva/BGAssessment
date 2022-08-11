<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rewardWheelToUser(Wheel $wheel) {
        // Remove previous reward and add new one
        $this->wheels()->detach();
        $this->wheels()->attach($wheel);

        // item rewarded by wheel
        $item = $this->wheels()->firstOrFail()->item;

        // Get users item and change its quantity based on reward
        $user_item = $this->getItemById($item->id);

        // If reward doesn't exist already, just add it in the pivot table
        if(!$user_item) {
            $this->items()->attach($item, ['quantity' => $wheel->quantity]);
        } else {
            // Else add quantity from reward
            $new_quantity = $user_item->pivot->quantity + $wheel->quantity;
            $user_item->updateItemQuantity($new_quantity);
        }
    }

    public function getItemById($item_id) {
        return $this->items()->where('item_id', $item_id)->first();
    }

    /**
     * Exchange logic and update user items quantity
     *
     * @param $exchanged
     * @param $exchange_into
     * @param $quantity
     * @return bool
     */
    public function doExchnage($exchanged, $exchange_into, $quantity) {
        $create = false;

        // Get the item we are exchanging
        $exchanged_item = $this->getItemById($exchanged);
        // If the user doesn't have the item, don't allow exchange
        if(!$exchanged_item) {
            return false;
        }

        // Item we want to exchange in
        $exchanged_into_item = $this->getItemById($exchange_into);

        // If the user doesn't have the item already, get the information from the items table
        if(!$exchanged_into_item){
            $exchanged_into_item = Item::find($exchange_into);
            $create = true;
        }

        // Calculate the quantities of the items for this user after the exchange
        $calculate_quantities = (new Exchange)->calculateNewQuantities($exchanged_item, $exchanged_into_item, $quantity);

        // If any errors appear, show error message
        if(!$calculate_quantities) {
            return false;
        }

        // Update the item we were exchanging
        $exchanged_item->updateItemQuantity($calculate_quantities['exchanged_item_new_quantity']);

        // If the item that was exchanged in does not exist, create the relation and save the quantity
        if($create) {
            $exchanged_into_item->saveItemQuantity($this->id, $calculate_quantities['exchanged_into_item_new_quantity']);
        } else {
            // Else update quantity
            $exchanged_into_item->updateItemQuantity($calculate_quantities['exchanged_into_item_new_quantity']);

        }

        return true;
    }

    /**
     * Relationships
     */
    public function items() {
        return $this->belongsToMany(Item::class, 'item_user', 'user_id', 'item_id')->withPivot('quantity');
    }
    public function wheels() {
        return $this->belongsToMany(Wheel::class);
    }


}
