<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     *  - Llama a los seeders ('parent')
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ListasTableSeeder::class);
        $this->call(ParticipaUserTableSeeder::class);
        
    }
}
