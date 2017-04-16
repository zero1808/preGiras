<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticrequirimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logisticrequiriments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idEvent')->unsigned()->nullable();
            $table->boolean('seguridad')->nullable();
            $table->boolean('ambulancia')->nullable();
            $table->boolean('bomberos')->nullable();
            $table->boolean('proteccion_civil')->nullable();
            $table->boolean('maestro_ceremonias')->nullable();
            $table->boolean('artista')->nullable();
            $table->boolean('edecanes')->nullable();
            $table->string('tipo_escenario',60)->nullable();
            $table->string('tipo_estrado',50);
            $table->string('fiscalizacion',50);
            $table->boolean('pull_cde')->nullable();
            $table->boolean('medios_locales')->nullable();
            $table->boolean('medios_nacionales')->nullable();
            $table->boolean('fotografo')->nullable();
            $table->boolean('otro_medio')->nullable();
            $table->boolean('hidratacion')->nullable();
            $table->boolean('coffeebreak')->nullable();
            $table->boolean('bocadillos')->nullable();
            $table->boolean('agua')->nullable();
            $table->boolean('otro_alimento')->nullable();
            $table->string('responsable_comunicacion',255)->nullable();
            $table->string('telefono_comunicacion',255)->nullable();
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
        Schema::dropIfExists('logisticrequiriments');
    }
}
