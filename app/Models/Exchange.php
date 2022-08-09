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

    public function getRate($exchanged, $exchange_into) {
        $exchange = Exchange::where('item_exchanged_id',$exchanged)
            ->where('item_exchanged_into_id', $exchange_into)
            ->first();
//        todo: if not exists
        return $exchange->rate;
    }

    public function calculateNewQuantity($exchanged, $exchange_into, $quantity) {
        $rate = $this->getRate($exchanged, $exchange_into);
        $exchange_quantity = $quantity * $rate;

        return $exchange_quantity;
    }

}
