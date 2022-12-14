<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Wheel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(10)->create();

        $this->call([
            ItemSeeder::class,
            ExchangeSeeder::class,
            UsersItemsSeeder::class,
        ]);

        Wheel::factory(10)->create();
    }
}
