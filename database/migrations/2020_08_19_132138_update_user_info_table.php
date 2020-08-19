<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('user_info', function($table) {
            $table->integer('preferred_min_age')->after('user_id')->nullable();
            $table->integer('preferred_max_age')->after('preferred_min_age')->nullable();
            $table->decimal('preferred_min_height' ,2,1)->after('preferred_max_age')->nullable();
            $table->decimal('preferred_max_height',2,1)->after('preferred_min_height')->nullable();
            $table->integer('preferred_min_weight')->after('preferred_max_height')->nullable();
            $table->integer('preferred_max_weight')->after('preferred_min_weight')->nullable();
            $table->integer('wish_to_meet')->after('preferred_max_weight')->nullable();
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
