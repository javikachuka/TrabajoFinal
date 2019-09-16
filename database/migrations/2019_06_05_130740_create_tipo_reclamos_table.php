<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoReclamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_reclamos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre') ;
            $table->string('detalle')->nullable() ;
            $table->boolean('trabajo') ;
            $table->unsignedBigInteger('flujoTrabajo_id')->nullable() ;
            $table->foreign('flujoTrabajo_id')->references('id')->on('flujo_trabajos') ;
            $table->unsignedBigInteger('prioridad_id') ;
            $table->foreign('prioridad_id')->references('id')->on('prioridades') ;
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
        Schema::dropIfExists('tipo_reclamos');
    }
}
