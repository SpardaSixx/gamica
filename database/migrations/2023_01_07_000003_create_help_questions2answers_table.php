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
        Schema::create('help_questions2answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('help_questions');
            $table->foreign('answer_id')->references('id')->on('help_answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('help_questions2answers', function (Blueprint $table) {
            $table->dropForeign('question_id');
            $table->dropForeign('answer_id');
        });

        Schema::dropIfExists('help_questions2answers');
    }
};
