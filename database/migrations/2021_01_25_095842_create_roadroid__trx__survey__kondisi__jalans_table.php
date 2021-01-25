<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoadroidTrxSurveyKondisiJalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roadroid_trx_survey_kondisi_jalans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ruas_jalan')->unsigned()->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('distance')->nullable();
            $table->string('speed')->nullable();
            $table->string('altitude')->nullable();
            $table->string('altitude-10')->nullable();
            $table->string('eiri')->nullable();
            $table->string('ciri')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roadroid__trx__survey__kondisi__jalans');
    }
}
