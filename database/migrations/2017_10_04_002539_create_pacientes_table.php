<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration {

    public function up() {
        Schema::create('pacientes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('cui',15)->nullabel();
          $table->string('nombre1');
          $table->string('nombre2')->nullable();
          $table->string('nombre3')->nullable();
          $table->string('apellido1');
          $table->string('apellido2')->nullable();
          $table->string('apellido3')->nullable();
          $table->integer('departamento_id');
          $table->integer('municipio_id');
          $table->string('direccion')->nullable();
          $table->string('fecha_nacimiento');
          $table->string('encargado')->nullable();
          $table->string('fecha_ingreso');
          $table->string('telefono')->nullable();
          $table->integer('medico_id');
          $table->string('seguro_social',10)->nullable();
          $table->string('observacion',500);
          $table->integer('pago_id');
          $table->foreign('departamento_id')->references('id')->on('departamentos')->onUpdate('cascade');
          $table->foreign('municipio_id')->references('id')->on('municipios')->onUpdate('cascade');
          $table->foreign('medico_id')->references('id')->on('medicos')->onUpdate('cascade');
          $table->foreign('pago_id')->references('id')->on('pagos')->onUpdate('cascade');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('pacientes');
    }
}
