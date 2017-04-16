<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBossplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bossplaces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idPlace')->unsigned()->nullable();
            $table->string('nombre',60);
            $table->string('cargo',50);
            $table->string('observaciones',100)->nullable();
            $table->string('foto')->nullable();
            $table->foreign('idPlace')->references('id')->on('places')->onDelete('cascade');
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
        Schema::dropIfExists('bossplaces');
    }
}
