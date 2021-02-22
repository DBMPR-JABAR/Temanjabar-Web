<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnDeskripsiUtilsTipeBangunanAtas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('utils_tipe_bangunan_atas', 'deskripsi')) {
            Schema::table('utils_tipe_bangunan_atas', function (Blueprint $table) {
                $table->string('deskripsi');
            });
        }
        if (!Schema::hasColumn('utils_tipe_bangunan_atas', 'created_at')) {
            Schema::table('utils_tipe_bangunan_atas', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utils_tipe_bangunan_atas', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
