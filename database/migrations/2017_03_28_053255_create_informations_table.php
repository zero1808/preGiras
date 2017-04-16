<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idEvent')->unsigned()->nullable();
            $table->string('tipo_evento',50);
            $table->string('vestimenta',50);
            $table->string('sugerencia_vestimenta',1000)->nullable();
            $table->string('rentabilidad',50);
            $table->string('trascendencia',100)->nullable();
            $table->integer('asistentes')->nullable();
            $table->string('participacion')->nullable();
            $table->string('sector',100);
            $table->string('tema',200);
            $table->string('folletos',10);
            $table->string('utilitarios',10);
            //$table->string('fiscalizacion',10);
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
        Schema::dropIfExists('informations');
    }
}
