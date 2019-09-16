<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReclamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclamos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha') ;
            $table->string('detalle')->nullable() ;
            $table->unsignedBigInteger('socio_id') ;
            $table->foreign('socio_id')->references('id')->on('socios') ;
            $table->unsignedBigInteger('user_id') ;
            $table->foreign('user_id')->references('id')->on('users') ;
            $table->unsignedBigInteger('tipoReclamo_id') ;
            $table->foreign('tipoReclamo_id')->references('id')->on('tipo_reclamos') ;
            $table->unsignedBigInteger('trabajo_id')->nullable() ;
            $table->foreign('trabajo_id')->references('id')->on('trabajos') ;

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
        Schema::dropIfExists('reclamos');
    }
}
