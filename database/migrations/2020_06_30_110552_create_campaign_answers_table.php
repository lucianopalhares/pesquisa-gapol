<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('interviewee_id');
            $table->foreign('interviewee_id')->references('id')->on('interviewees');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->text('question_description');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->text('answer_description');
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
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
        Schema::dropIfExists('campaign_answers');
    }
}
