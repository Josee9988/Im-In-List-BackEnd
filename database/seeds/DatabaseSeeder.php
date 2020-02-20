<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * run
     * Summary: Llama a los seeders ('parent')
     * 
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ListasTableSeeder::class);
        
    }
}
