<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid('meeting_id')->nullable(false);
            $table->unsignedBigInteger('ref_user_id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('division', 512);
            $table->string('position', 512);
            $table->string('phone');
            $table->text('signature')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();

            $table->foreign('ref_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
