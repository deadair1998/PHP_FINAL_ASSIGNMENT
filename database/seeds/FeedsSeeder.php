<?php

use Illuminate\Database\Seeder;

class FeedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Feed', 10)->create();
    }
}
