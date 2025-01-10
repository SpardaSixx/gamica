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
        Schema::create('consoles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('release_year')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('serial_number')->nullable()->default(NULL);
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('version')->nullable();
            $table->unsignedBigInteger('box');
            $table->unsignedBigInteger('papers');
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
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consoles', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('company_id');
            $table->dropForeign('region_id');
        });

        Schema::dropIfExists('consoles');
    }
};
