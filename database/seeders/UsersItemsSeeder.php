<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $n = 0;
        $random = [];
        while($n < 20)
        {
            $rand_user = rand(1,10);
            $rand_item = rand(1,4);
            $pair = $rand_user.','.$rand_item;

            if(array_search($pair, $random)) {
                continue;
            } else {
                \DB::table('item_user')->insert([
                    'user_id' => $rand_user,
                    'item_id' => $rand_item,
                    'quantity' => rand(1,50)
                ]);
                $random[] = $pair;
                $n++;
            }
        }
    }
}
