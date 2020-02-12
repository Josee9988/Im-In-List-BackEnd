<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipaUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('participa_users')->insert([
            'idUser' => 1,
            'idLista' =>2,
        ]);

        DB::table('participa_users')->insert([
            'idUser' => 2,
            'idLista' =>1,
        ]);
    }
}
