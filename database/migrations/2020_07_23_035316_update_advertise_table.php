<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdvertiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'phone'))
        {
            Schema::table('advertise', function($table) {
                $table->dropColumn('description');
            });
        }
        Schema::table('advertise', function($table) {
                $table->integer('parent_id')->after('title')->nullable();
                $table->integer('ad_type')->after('parent_id')->nullable();
                $table->integer('ad_status')->after('ad_type')->nullable();
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
