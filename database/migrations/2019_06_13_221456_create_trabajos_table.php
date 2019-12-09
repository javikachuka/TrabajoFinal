<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha') ;
            $table->dateTime('horaInicio')->nullable() ;
            $table->dateTime('horaFin')->nullable() ;
            $table->string('observacion')->nullable() ;
            $table->string('urlFoto')->nullable() ;
            $table->unsignedBigInteger('estado_id')->nullable() ;
            $table->foreign('estado_id')->references('id')->on('estados') ;
            $table->timestamps();
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
        Schema::dropIfExists('trabajos');
    }
}
