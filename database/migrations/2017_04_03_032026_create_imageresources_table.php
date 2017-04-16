<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageresourcesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('imageresources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idRequeriments')->unsigned()->nullable();
            $table->integer('cantidad');
            $table->string('tipo', 255);
            $table->string('observaciones', 255)->nullable();
            $table->foreign('idRequeriments')->references('id')->on('logisticrequiriments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('imageresources');
    }

}
