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
        if (Schema::hasColumn('advertise', 'ad_type'))
        {
            Schema::table('advertise', function($table) {
                $table->dropColumn('ad_type');
            });
            Schema::table('advertise', function($table) {
                $table->integer('ad_category')->after('parent_id')->nullable();
                $table->date('start_date')->after('ad_category')->nullable();
                $table->date('expiration_date')->after('start_date')->nullable();
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
