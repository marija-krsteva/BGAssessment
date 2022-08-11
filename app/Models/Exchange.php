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

    /**
     * Get the exchange rate between two items
     *
     * @param $exchanged
     * @param $exchange_into
     * @return mixed
     */
    public function getRate($exchanged, $exchange_into) {
        $exchange = Exchange::where('item_exchanged_id',$exchanged)
            ->where('item_exchanged_into_id', $exchange_into)
            ->firstOrFail();

        return $exchange->rate;
    }

    /**
     * Calculate quantity based on exchange rate
     *
     * @param $exchanged
     * @param $exchange_into
     * @param $quantity
     * @return array|false
     */
    public function calculateNewQuantities($exchanged, $exchange_into, $quantity) {
        // Get the exchange rate
        $rate = $this->getRate($exchanged->id, $exchange_into->id);

        // If the user doesn't have the item we are exchanging into, take 0 as its quantity
        $exchange_into_item_quantity = !$exchange_into->pivot ? 0 : $exchange_into->pivot->quantity;

        // Calculate new quantities based on rate and quantity
        $exchanged_item_new_quantity = intval( $exchanged->pivot->quantity ) - ( $quantity / $rate );
        $exchanged_into_item_new_quantity = intval( $exchange_into_item_quantity ) + $quantity;

        // Make sure user has enough quantity to make the exchange, and the exchange returns full (non decimal) item quantity
        if($exchanged_item_new_quantity < 0 || fmod($exchanged_item_new_quantity, 1) != 0) {
            return false;
        }

        return [
            'exchanged_item_new_quantity' => $exchanged_item_new_quantity,
            'exchanged_into_item_new_quantity' => $exchanged_into_item_new_quantity
        ];
    }

}
