<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_ITEMS = ['5 free spins', '10 free spins', '5 euros', '1 Raffle ticket'];

        foreach( $_ITEMS as $ITEM) {
            Item::firstOrCreate(['name' => $ITEM]);
        }
    }
}
