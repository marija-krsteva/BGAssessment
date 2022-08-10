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
        $rate = $this->getRate($exchanged->id, $exchange_into->id);

        // Calculate new quantities based on rate and quantity
        $exchanged_item_new_quantity = intval( $exchanged->pivot->quantity ) - ( $quantity / $rate );
        $exchanged_into_item_new_quantity = intval( $exchange_into->pivot->quantity ) + ( $quantity * $rate );

        // Make sure user has enough quantity to make the exchange
        if($exchanged_item_new_quantity < 0) {
            return false;
        }

        return [
            'exchanged_item_new_quantity' => $exchanged_item_new_quantity,
            'exchanged_into_item_new_quantity' => $exchanged_into_item_new_quantity
        ];
    }

}
