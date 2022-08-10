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

    public function getItemById($item_id) {
        return $this->items()->where('item_id', $item_id)->firstOrFail();
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
        $exchanged_item = $this->getItemById($exchanged);
        $exchanged_into_item = $this->getItemById($exchange_into);

        $calculate_quantities = (new Exchange)->calculateNewQuantities($exchanged_item, $exchanged_into_item, $quantity);
        if(!$calculate_quantities) {
            return false;
        }

        $exchanged_item->saveItemQuantity($calculate_quantities['exchanged_item_new_quantity']);
        $exchanged_into_item->saveItemQuantity($calculate_quantities['exchanged_into_item_new_quantity']);

        return true;
    }

    /**
     * Relationships
     */
    public function items() {
        return $this->belongsToMany(Item::class, 'item_user', 'user_id', 'item_id')->withPivot('quantity');
    }

}
