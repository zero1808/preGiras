<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 255);
            $table->timestamp('f_inicio')->nullable();
            $table->timestamp('f_final')->nullable();
            $table->string('hora_arribo',10)->nullable();
            $table->string('hora_convocatoria',10)->nullable();
            $table->string('calle_numero', 300)->nullable();
            $table->string('colonia', 250)->nullable();
            $table->string('cp', 5)->nullable();
            $table->integer('idMunicipio')->unsigned()->nullable();
            $table->string('seccion_impactada',5);
            $table->string('distrito_impactado',20);
            $table->string('responsable_politico',255);  
            $table->string('cargo_responsable_politico',255)->nullable();  
            $table->string('foto_responsable_politico',400)->nullable();
            $table->string('telefono_responsable_politico',10);
            $table->string('email_responsable_politico',100)->nullable(); 
            $table->string('responsable_operativo',255);  
            $table->string('cargo_responsable_operativo',255)->nullable();  
            $table->string('foto_responsable_operativo',400)->nullable();
            $table->string('telefono_responsable_operativo',10);
            $table->string('email_responsable_operativo',100)->nullable();   
            $table->string('objetivo', 1000)->nullable();
            $table->integer('idResponsable')->unsigned()->nullable();
            $table->integer('status');
            $table->string('lat', 200)->nullable();
            $table->string('lng', 200)->nullable();
            $table->integer('contador_pdf')->nullable();
            $table->foreign('idMunicipio')->references('id')->on('municipalities')->onDelete('set null');
            $table->foreign('idResponsable')->references('id')->on('profiles')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('events');
    }

}
