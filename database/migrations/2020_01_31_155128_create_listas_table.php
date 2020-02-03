<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idUsuarioCreador')->unsigned()->unique();
            $table->foreign('idUsuarioCreador')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('passwordLista');
            $table->json('elementos');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listas');
    }
}
