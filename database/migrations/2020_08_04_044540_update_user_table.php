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
            $table->integer('age')->after('dob')->nullable();
            $table->integer('gender')->after('age')->nullable();
            $table->integer('preferred_height')->after('preferred_age')->nullable();
            $table->integer('preferred_weight')->after('preferred_height')->nullable();
            $table->integer('login_status')->after('status')->nullable();
            $table->string('ethnicity_other')->after('ethnicity')->nullable();
            $table->string('build_other')->after('build')->nullable();
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
