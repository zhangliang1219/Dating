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
            $table->integer('phone')->after('password')->nullable();
            $table->integer('is_admin')->after('phone')->nullable();
            $table->integer('status')->after('is_admin')->nullable();
            $table->integer('phone_verify')->after('status')->nullable();
            $table->integer('email_verify')->after('phone_verify')->nullable();
            $table->integer('id_verify')->after('email_verify')->nullable();
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
        //
    }
}
