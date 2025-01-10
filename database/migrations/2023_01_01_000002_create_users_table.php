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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('default_language')->nullable()->default(NULL);
            $table->string('fb_profile')->nullable();
            $table->string('ig_profile')->nullable();
            $table->integer('xp_points')->default(0);
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->boolean('has_photo')->nullable();
            $table->boolean('deleted')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('rank_id')->references('id')->on('ranks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('city_id');
            $table->dropForeign('rank_id');
        });

        Schema::dropIfExists('users');
    }
};
