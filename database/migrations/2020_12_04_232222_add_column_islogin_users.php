<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsloginUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'is_login')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('is_login');
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
        if (Schema::hasColumn('users', 'is_login')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_login');
            });
        }
    }
}
