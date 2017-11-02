<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacorasTables extends Migration {

    public function up() {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usuario', 50)->nullable();
            $table->string('nombre_tabla', 50);
            $table->string('actividad', 25);
            $table->string('anterior', 550)->nullable();
            $table->string('nuevo', 1000)->nullable();
            $table->date('fecha')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down() {
        Schema::dropIfExists('bitacoras');
    }
}
