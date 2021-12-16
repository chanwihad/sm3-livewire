<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 512);
            $table->string('description', 1024)->nullable();
            $table->date('date');
            $table->string('time', 64)->nullable();
            $table->string('place')->nullable();
            $table->unsignedBigInteger('creator');
            $table->string('participant', 1024)->nullable();
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('creator')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
