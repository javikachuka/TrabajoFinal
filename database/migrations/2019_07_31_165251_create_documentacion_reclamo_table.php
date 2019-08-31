<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentacionReclamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentacion_reclamo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('documentacion_id');
            $table->unsignedBigInteger('reclamo_id');
            $table->timestamps();

            $table->foreign('documentacion_id')->references('id')->on('documentaciones');
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
        Schema::dropIfExists('documentacion_reclamo');
    }
}
