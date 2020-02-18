<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ListasTableSeeder extends Seeder
{
    /**
     *  - Inserta los datos en la tabla
     */
    public function run()
    {
        DB::table('listas')->insert([
            'user_id' => 1,
            'URL' => 'Borja_UrlBorjaList',
            'titulo' => 'Lista Borja',
            'descripcion' => 'La lista de Borja',
            'passwordLista' => Hash::make('1234'),
            'elementos' => str_replace("'", "\'", json_encode(['Comprar platanos', 'Comprar Melocotones'])),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('listas')->insert([
            'user_id' => 2,
            'URL' => 'Jose_UrlJoseList',
            'titulo' => 'Lista Jose',
            'descripcion' => 'La lista de Jose',
            'passwordLista' => Hash::make('1234'),
            'elementos' => str_replace("'", "\'", json_encode(['Comprar agua', 'Comprar lapices'])),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('listas')->insert([
            'user_id' => 3,
            'URL' => 'Registrado_' . $this->random(),
            'titulo' => 'Lista Registrado',
            'descripcion' => 'La lista de Registradp',
            'passwordLista' => Hash::make('1234'),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('listas')->insert([
            'user_id' => 2,
            'URL' => 'Jose_JoseList2',
            'titulo' => 'Lista JOSE 2',
            'descripcion' => 'La lista de OJSE',
            'passwordLista' => Hash::make('1234'),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

    }

    public function random()
    {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
