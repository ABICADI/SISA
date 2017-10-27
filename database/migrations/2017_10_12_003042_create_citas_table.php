<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start');
            $table->string('title'); //nombre de paciente en eventos del calendario
            $table->string('color'); //color de terapia para identificacion de eventos en calendario
            $table->string('asistencia')->nullable();
            $table->string('observacion')->nullable();
            $table->integer('tratamiento_id');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
