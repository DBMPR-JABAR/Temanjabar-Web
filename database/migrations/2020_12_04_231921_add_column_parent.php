<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('user_role', 'parent_id')) {
            Schema::table('user_role', function (Blueprint $table) {
                $table->integer('parent_id');
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
        if (!Schema::hasColumn('user_role', 'parent_id')) {
            Schema::table('user_role', function (Blueprint $table) {
                $table->dropColumn('parent_id');
            });
        }
    }
}
