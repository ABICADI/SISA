<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTratamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 500)->nullable();
            $table->date('fecha')->nullable();
            $table->integer('asignados')->nullable(); //dias asignados
            $table->integer('restantes')->nullable();  //dias restantes
            $table->integer('paciente_id');
            $table->integer('medico_id');
            $table->integer('terapia_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onUpdate('cascade');
            $table->foreign('medico_id')->references('id')->on('medicos')->onUpdate('cascade');
            $table->foreign('terapia_id')->references('id')->on('terapias')->onUpdate('cascade');
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
        Schema::dropIfExists('tratamientos');
    }
}
