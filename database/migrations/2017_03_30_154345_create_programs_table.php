<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idEvent')->unsigned()->nullable();
            $table->string('contenido',4000)->nullable();
            $table->string('asistentes_ficha',4000)->nullable();
            $table->string('url_contenido',255)->nullable();
            $table->string('url_programa',255)->nullable();
            $table->string('estado_entrega',50);
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
        Schema::dropIfExists('programs');
    }
}
