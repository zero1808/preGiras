<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialassistansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialassistans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero');
            $table->integer('idProgram')->unsigned()->nullable();
            $table->string('nombre',255);
            $table->string('cargo',255)->nullable();
            $table->string('observaciones',255)->nullable();
            $table->string('foto',255)->nullable();
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
        Schema::dropIfExists('especialassistans');
    }
}
