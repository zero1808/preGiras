<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComitereceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comitereceptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idInformation')->unsigned()->nullable();
            $table->string('nombre',255);
            $table->string('cargo',255)->nullable();
            $table->string('observaciones',255)->nullable();
            $table->string('foto',255)->nullable();
            $table->foreign('idInformation')->references('id')->on('informations')->onDelete('cascade');
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
        Schema::dropIfExists('comitereceptions');
    }
}
