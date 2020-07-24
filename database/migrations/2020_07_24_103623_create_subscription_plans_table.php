<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->integer('language_id')->nullable();
            $table->string('free_gender')->nullable();
            $table->integer('recurring_payment')->nullable();
            $table->integer('status')->nullable();
            $table->integer('subscribe_by_default')->nullable();
            $table->integer('swipe_with_like_dislike')->nullable();
            $table->integer('photo_upload')->nullable();
            $table->integer('send_mail')->nullable();
            $table->integer('instant_message')->nullable();
            $table->integer('live_video_chat')->nullable();
            $table->integer('coaching')->nullable();
            $table->integer('who_viewed_me')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('subscription_plans');
    }
}
