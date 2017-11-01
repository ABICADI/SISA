<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserdiasemanasTable extends Migration {

    public function up() {
        Schema::create('userdiasemanas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('diasemana_id');
            $table->integer('user_id');
            $table->foreign('diasemana_id')->references('id')->on('diasemanas')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists('userdiasemanas');
    }
}
