<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitoTipoReclamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisito_tipo_reclamo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisito_id');
            $table->foreign('requisito_id')->references('id')->on('requisitos') ;
            $table->unsignedBigInteger('tipo_reclamo_id');
            $table->foreign('tipo_reclamo_id')->references('id')->on('tipo_reclamos') ;
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
        Schema::dropIfExists('requisito_tipo_reclamo');
    }
}
