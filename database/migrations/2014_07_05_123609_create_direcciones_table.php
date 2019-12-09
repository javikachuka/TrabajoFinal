<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDireccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('zona_id') ;
            $table->string('calle') ;
            $table->integer('altura') ;
            $table->bigInteger('nro_conexion')->nullable();
            $table->unsignedBigInteger('socio_id')->nullable() ;
            $table->foreign('socio_id')->references('id')->on('socios') ;
            $table->timestamps();
            $table->foreign('zona_id')->references('id')->on('zonas') ;
            $table->softDeletes() ;


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direcciones');
    }
}
