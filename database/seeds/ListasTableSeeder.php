<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ListasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('listas')->insert([
            'user_id' => 1,
            'titulo' => 'Lista Borja',
            'descripcion'=> 'La lista de Borja',
            'passwordLista' => Hash::make('1234'),
            'elementos'=>str_replace("'", "\'", json_encode(['Comprar platanos','Comprar Melocotones'])),
        ]);

        DB::table('listas')->insert([
            'user_id' => 2,
            'titulo' => 'Lista Jose',
            'descripcion'=> 'La lista de Jose',
            'passwordLista' => Hash::make('1234'),
            'elementos'=>str_replace("'", "\'", json_encode(['Comprar agua','Comprar lapices'])),
        ]);
    }
}
