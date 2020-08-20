<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'wish_to_meet'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('wish_to_meet');
            });
        }
        if (Schema::hasColumn('users', 'preferred_age'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('preferred_age');
            });
        }
        if (Schema::hasColumn('users', 'preferred_height'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('preferred_height');
            });
        }
        if (Schema::hasColumn('users', 'preferred_weight'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('preferred_weight');
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
        //
    }
}
