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
       Schema::table('users', function($table) {
            $table->integer('normal_login')->after('status')->nullable();
            $table->integer('facebook_login')->after('normal_login')->nullable();
            $table->integer('google_login')->after('facebook_login')->nullable();
            $table->integer('instagram_login')->after('google_login')->nullable();
        });
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
