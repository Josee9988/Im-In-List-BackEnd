<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'borja',
            'email' => 'borja@gmail.com',
            'password' => Hash::make('1234'),
            'listasCreadas'=>str_replace("'", "\'", json_encode([1])),
            'listasParticipantes'=>str_replace("'", "\'", json_encode([1,2])),
            'role' => 0,
        ]);

        DB::table('users')->insert([
            'name' => 'jose',
            'email' => 'jose@gmail.com',
            'password' => Hash::make('1234'),
            'listasCreadas'=>str_replace("'", "\'", json_encode([2])),
            'listasParticipantes'=>str_replace("'", "\'", json_encode([1,2])),
            'role' => 0,
        ]);

    }
}
