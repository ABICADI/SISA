<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserterapiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userterapias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('terapia_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
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
        Schema::dropIfExists('userterapias');
    }
}
