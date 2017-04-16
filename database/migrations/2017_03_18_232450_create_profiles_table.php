<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned();
            $table->string('name',255);
            $table->string('ap_paterno',255);
            $table->string('ap_materno',255);
            $table->string('direccion',255);
            $table->integer('idMunicipio')->unsigned()->nullable();
            $table->string('telefono_cel',10);
            $table->string('telefono_casa',10);
            $table->integer('status');
            $table->integer('idTeam')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idMunicipio')->references('id')->on('municipalities')->onDelete('set null');
            $table->foreign('idTeam')->references('id')->on('teams')->onDelete('set null');
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
        Schema::dropIfExists('profiles');
    }
}
