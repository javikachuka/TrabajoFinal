<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transicions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre') ;
            $table->unsignedBigInteger('flujoTrabajo') ;
            $table->foreign('flujoTrabajo')->references('id')->on('flujo_trabajos') ;
            $table->unsignedBigInteger('estadoInicial')  ;
            $table->foreign('estadoInicial')->references('id')->on('estados') ;
            $table->unsignedBigInteger('estadoFinal')  ;
            $table->foreign('estadoFinal')->references('id')->on('estados') ;
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
        Schema::dropIfExists('transicions');
    }
}
