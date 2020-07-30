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
        if (Schema::hasColumn('users', 'age'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('age');
            });
        }else if (Schema::hasColumn('users', 'gender'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('gender');
            });
        }
        Schema::table('users', function($table) {
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->date('dob')->after('last_name')->nullable();
            $table->integer('wish_to_meet')->after('phone')->nullable();
            $table->string('preferred_age')->after('wish_to_meet')->nullable();
            $table->integer('ethnicity')->after('preferred_age')->nullable();
            $table->integer('height')->after('ethnicity')->nullable();
            $table->integer('weight')->after('height')->nullable();
            $table->integer('build')->after('weight')->nullable();
            $table->integer('relationship')->after('build')->nullable();
            $table->integer('living_arrangement')->after('relationship')->nullable();
            $table->string('city')->after('living_arrangement')->nullable();
            $table->string('state')->after('city')->nullable();
            $table->integer('country')->after('state')->nullable();
            $table->string('favorite_sport')->after('country')->nullable();
            $table->string('high_school_attended')->after('favorite_sport')->nullable();
            $table->string('collage')->after('high_school_attended')->nullable();
            $table->integer('employment_status')->after('collage')->nullable();
            $table->integer('education')->after('employment_status')->nullable();
            $table->integer('children')->after('education')->nullable();
            $table->date('describe_perfect_date')->after('children')->nullable();
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
