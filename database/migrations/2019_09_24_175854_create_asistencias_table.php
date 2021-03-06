<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('dia') ;
            $table->time('horaEntrada')->nullable() ;
            $table->string('urlFoto')->nullable() ;
            $table->time('horaSalida')->nullable() ;
            $table->boolean('presente') ;
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users') ;
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
        Schema::dropIfExists('asistencias');
    }
}
