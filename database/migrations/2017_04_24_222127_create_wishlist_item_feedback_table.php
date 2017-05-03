<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistItemFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Schema::create('wishlist_item_feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('wishlist_id')->unsigned();
            $table->foreign('wishlist_id')->references('id')->on('wishlists');
            $table->integer('appliance_id')->unsigned();
            $table->foreign('appliance_id')->references('id')->on('appliances');
            $table->boolean('dislike');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Schema::dropIfExists('wishlist_item_feedbacks');
    }
}
