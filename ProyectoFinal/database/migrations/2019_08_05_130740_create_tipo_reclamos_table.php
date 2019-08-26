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
            $table->unsignedBigInteger('reclamo_id') ;
            $table->string('nombre') ;
            $table->timestamps();

            $table->foreign('reclamo_id')->references('id')->on('reclamos');
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
