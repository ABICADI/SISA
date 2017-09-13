<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->integer('departamento_id');
            $table->integer('municipio_id');
            $table->string('direccion')->nullable();
            $table->date('fecha_nacimiento');
            $table->date('fecha_ingreso');
            $table->string('telefono')->nullable();
            //$table->string('foto')->nullable();
            $table->integer('rol_id');
            $table->date('fecha_egreso')->nullable();
            $table->integer('estado_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onUpdate('cascade');
            $table->foreign('municipio_id')->references('id')->on('municipios')->onUpdate('cascade');
            $table->foreign('rol_id')->references('id')->on('rols')->onUpdate('cascade');
            $table->foreign('estado_id')->references('id')->on('estados')->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
