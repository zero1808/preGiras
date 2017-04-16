<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idEvent')->unsigned()->nullable();
            $table->string('lugar',30);
            $table->string('descripcion',500)->nullable();
            $table->string('acceso_lugar',50);
            $table->string('imagen_frente',500)->nullable();
            $table->string('imagen_atras',500)->nullable();
            $table->string('imagen_exterior')->nullable();
            $table->string('riesgos',500)->nullable();
            $table->string('problematica')->nullable();
            $table->foreign('idEvent')->references('id')->on('events')->onDelete('cascade');
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
        Schema::dropIfExists('places');
    }
}
