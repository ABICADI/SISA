<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration {

    public function up() {
        Schema::create('pacientes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('cui',15)->nullable();
          $table->string('nombre1');
          $table->string('nombre2')->nullable();
          $table->string('nombre3')->nullable();
          $table->string('apellido1');
          $table->string('apellido2')->nullable();
          $table->string('apellido3')->nullable();
          $table->integer('municipio_id');
          $table->string('direccion')->nullable();
          $table->string('fecha_nacimiento');
          $table->string('encargado')->nullable();
          $table->string('fecha_ingreso');
          $table->string('telefono')->nullable();
          $table->string('seguro_social',10);
          $table->string('observacion',1000)->nullable();
          $table->integer('pago_id');
          $table->integer('genero_id');
          $table->foreign('municipio_id')->references('id')->on('municipios')->onUpdate('cascade');
          $table->foreign('pago_id')->references('id')->on('pagos')->onUpdate('cascade');
          $table->foreign('genero_id')->references('id')->on('generos')->onUpdate('cascade');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('pacientes');
    }
}
