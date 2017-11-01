<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration {

    public function up() {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start');
            $table->string('title');
            $table->string('color');
            $table->integer('tratamiento_id');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('citas');
    }
}
