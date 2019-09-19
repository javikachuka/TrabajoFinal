<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_estados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reclamo_id');
            $table->foreign('reclamo_id')->references('id')->on('reclamos') ;
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estados') ;
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
        Schema::dropIfExists('historial_estados');
    }
}
