<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastAccessedCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_course', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_course_id')->unsigned();
            $table->unsignedBigInteger('teacher_id')->unsigned();
            $table->timestamps();

            $table->foreign('teacher_course_id')->references('id')->on('teacher_course');
            $table->foreign('teacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('last_course');
    }
}
