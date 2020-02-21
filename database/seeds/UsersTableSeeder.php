<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * run
     * Summary: Inserta los datos en la tabla
     *
     * @return void
     */
    public function run()
    {
        // - ADMINS -----------------------------------------------------
        DB::table('users')->insert([
            'name' => 'borja',
            'email' => 'borja@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'jose',
            'email' => 'jose@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'alejandro',
            'email' => 'alejandro@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        // - USERS -----------------------------------------------------
        DB::table('users')->insert([
            'name' => 'registrado',
            'email' => 'registrado@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 1,
            'created_at' => '2020-01-01',
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'registrado2',
            'email' => 'registrado2@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'registrado3',
            'email' => 'registrado3@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'registrado4',
            'email' => 'registrado4@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 1,
            'created_at' => '2020-03-01',
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'premium',
            'email' => 'premium@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 2,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'premium2',
            'email' => 'premium2@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 2,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'premium3',
            'email' => 'premium3@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 2,
            'created_at' => '2020-01-01',
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('users')->insert([
            'name' => 'premium4',
            'email' => 'premium4@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 2,
            'created_at' => '2020-03-01',
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

    }
}
