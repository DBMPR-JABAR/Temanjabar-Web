<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsJembatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasColumn('user_role', 'parent_id')) {
        Schema::table('master_jembatan', function (Blueprint $table) {
            $table->string('status', 50)->nullable();
            $table->string('kondisi', 100)->nullable();
            $table->integer('debit_air')->nullable();
            $table->integer('tinggi_jagaan')->nullable();
            $table->integer('id_jenis_jembatan')->nullable();
        });
        // }    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_jembatan', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('kondisi');
            $table->dropColumn('debit_air');
            $table->dropColumn('tinggi_jagaan');
            $table->dropColumn('id_jenis_jembatan');
        });
    }
}
