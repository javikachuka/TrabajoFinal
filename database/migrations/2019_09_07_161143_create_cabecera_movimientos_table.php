<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabeceraMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabecera_movimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->date('fechaComprobante')->nullable();
            $table->bigInteger('numeroComprobante')->nullable();
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores') ;
            $table->unsignedBigInteger('trabajo_id')->nullable();
            $table->foreign('trabajo_id')->references('id')->on('trabajos') ;
            $table->unsignedBigInteger('tipoComprobante_id')->nullable();
            $table->foreign('tipoComprobante_id')->references('id')->on('tipo_comprobantes') ;
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
        Schema::dropIfExists('cabecera_movimientos');
    }
}
