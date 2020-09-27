<?php

use Illuminate\Database\Seeder;

class TypeRoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Type_room::class, 10)->create();
    }
}
