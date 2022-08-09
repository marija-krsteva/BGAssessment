<?php

namespace Database\Seeders;

use App\Models\Exchange;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_DEFAULT_EXCHANGES =
            [
                ['item_exchanged_id' => '1','item_exchanged_into_id' => '2','rate' => '0.5'],
                ['item_exchanged_id' => '2','item_exchanged_into_id' => '1','rate' => '2'],
                ['item_exchanged_id' => '2','item_exchanged_into_id' => '3','rate' => '2'],
                ['item_exchanged_id' => '3','item_exchanged_into_id' => '1','rate' => '1'],
                ['item_exchanged_id' => '3','item_exchanged_into_id' => '2','rate' => '2'],
            ];

        foreach ($_DEFAULT_EXCHANGES as $DEFAULT_EXCHANGE) {
            Exchange::firstOrCreate($DEFAULT_EXCHANGE);
        }
    }
}
