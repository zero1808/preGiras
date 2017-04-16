<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeccionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccionals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_externo');
            $table->integer('distrito');
            $table->integer('entidad');
            $table->string('geometry',255);
            $table->integer('external_id');
            $table->string('folder',255);
            $table->integer('municipio')->unsigned()->nullable();
            $table->string('seccion',255);
            $table->integer('tipo');
            $table->string('coordinates',10000);
            $table->foreign('municipio')->references('id')->on('municipalities')->onDelete('cascade');
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
        Schema::dropIfExists('seccionals');
    }
}
