<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apellido') ;
            $table->string('nombre') ;
            $table->integer('dni') ;
            $table->integer('nro_conexion');
            $table->unsignedBigInteger('domicilio_id') ;
            $table->timestamps();

            $table->foreign('domicilio_id')->references('id')->on('domicilios') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socios');
    }
}
