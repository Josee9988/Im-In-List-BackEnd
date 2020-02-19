<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListasTable extends Migration
{
    /**
     *  - Estructura de las tablas
     */
    public function up()
    {
        Schema::create('listas', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('url')->unique();
            $table->string('titulo')->nullable()->default('Nuevo_Titulo');
            $table->string('descripcion')->nullable()->default('Nueva_descripcion');
            $table->string('passwordLista')->nullable();
            $table->json('elementos')->nullable();
            $table->timestamps();
        });

    }

    /**
     * - Elimina tabla
     */
    public function down()
    {
        Schema::dropIfExists('listas');
    }
}
