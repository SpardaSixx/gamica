<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('release_year')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->string('serial_number')->nullable()->default(NULL);
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('release_id')->nullable();
            $table->unsignedBigInteger('cover_language_id')->nullable();
            $table->unsignedBigInteger('game_language_id')->nullable();
            $table->boolean('manual')->default(0);
            $table->boolean('special_edition')->default(0);
            $table->boolean('has_photo')->default(0);
            $table->integer('gallery_amount')->nullable();
            $table->boolean('sealed')->default(0);
            $table->integer('price')->nullable();
            $table->boolean('delivery')->default(0);
            $table->boolean('is_sold')->default(0);
            $table->boolean('deleted')->default(0);
            $table->boolean('is_highlighted')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('release_id')->references('id')->on('releases');
            $table->foreign('cover_language_id')->references('id')->on('languages');
            $table->foreign('game_language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('platform_id');
            $table->dropForeign('region_id');
            $table->dropForeign('release_id');
            $table->dropForeign('cover_language_id');
            $table->dropForeign('game_language_id');
        });

        Schema::dropIfExists('sales');
    }
};
