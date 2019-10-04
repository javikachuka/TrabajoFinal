<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cantidad') ;
            $table->double('precio')->nullable() ;
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos') ;
            $table->unsignedBigInteger('tipo_movimiento_id');
            $table->foreign('tipo_movimiento_id')->references('id')->on('tipo_movimientos') ;
            $table->unsignedBigInteger('cabecera_movimiento_id');
            $table->foreign('cabecera_movimiento_id')->references('id')->on('cabecera_movimientos') ;
            $table->unsignedBigInteger('almacenOrigen_id')->nullable();
            $table->foreign('almacenOrigen_id')->references('id')->on('almacenes') ;
            $table->unsignedBigInteger('almacenDestino_id')->nullable();
            $table->foreign('almacenDestino_id')->references('id')->on('almacenes') ;
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
        Schema::dropIfExists('movimientos');
    }
}
