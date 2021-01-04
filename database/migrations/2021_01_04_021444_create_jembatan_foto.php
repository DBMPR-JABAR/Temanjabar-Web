<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJembatanFoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_jembatan_foto', function (Blueprint $table) {
            $table->id();
            $table->integer('id_jembatan')->unsigned();
            $table->string('nama', 100);
            $table->text('foto');
            $table->foreign('id_jembatan')->references('id')->on('master_jembatan')->onUpdate('cascade')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_jembatan_foto');
    }
}
