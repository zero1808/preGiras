<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dayorders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idProgram')->unsigned()->nullable();
            $table->integer('np');
            $table->string('intervencion',250)->nullable();
            $table->string('accion',255);
            $table->string('nombre',255);
            $table->string('cargo',255)->nullable();
            $table->string('minutos',255)->nullable();
            $table->foreign('idProgram')->references('id')->on('programs')->onDelete('cascade');
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
        Schema::dropIfExists('dayorders');
    }
}
