<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('dpi', 15);
            $table->string('nombre1');
            $table->string('nombre2')->nullable();
            $table->string('nombre3')->nullable();
            $table->string('apellido1');
            $table->string('apellido2')->nullable();
            $table->string('apellido3')->nullable();
            $table->integer('municipio_id');
            $table->string('direccion')->nullable();
            $table->string('fecha_nacimiento');
            $table->string('fecha_ingreso');
            $table->string('telefono')->nullable();
            $table->integer('rol_id');
            $table->string('fecha_egreso')->nullable();
            $table->integer('estado_id');
            $table->integer('genero_id');
            $table->foreign('municipio_id')->references('id')->on('municipios')->onUpdate('cascade');
            $table->foreign('rol_id')->references('id')->on('rols')->onUpdate('cascade');
            $table->foreign('estado_id')->references('id')->on('estados')->onUpdate('cascade');
            $table->foreign('genero_id')->references('id')->on('generos')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }
}
