<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    public function hasEnoughQuantity($exchanged, $quantity) {
        $item = $this->items()->where('item_exchanged_id',$exchanged)->first();
        return $item->quantity < $quantity;
    }

    public function doExchnage($exchanged, $exchange_into, $quantity) {
        $exchanged_item = $this->items()->where('item_exchanged_id', $exchanged)->first();
        $exchanged_into_item = $this->items()->where('exchange_into', $exchanged)->first();

        $exchanged_item_new_quantity = intval($exchanged_item->quantity) - $quantity;
        $exchanged_into_item_new_quantity = (new Exchange)->calculateNewQuantity($exchanged, $exchange_into, $quantity);

        $exchanged_item->update(['quantity' => $exchanged_item_new_quantity]);
        $exchanged_into_item->update(['quantity' => $exchanged_into_item_new_quantity]);
    }

    public function items() {
        return $this->belongsToMany(Item::class);
    }

}
