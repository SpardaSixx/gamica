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
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_short')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->integer('release_year')->nullable();
            $table->text('description')->nullable();
            $table->integer('amount')->nullable();
            $table->boolean('deleted')->default(0);
            $table->boolean('has_photo')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('platforms', function (Blueprint $table) {
            $table->dropForeign('company_id');
        });

        Schema::dropIfExists('platforms');
    }
};
