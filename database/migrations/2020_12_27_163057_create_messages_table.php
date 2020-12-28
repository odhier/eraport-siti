<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_class_id')->unsigned();
            $table->integer('semester');
            $table->unsignedBigInteger('teacher_course_id')->unsigned();
            $table->integer('ki');
            $table->longText('deskripsi');
            $table->timestamps();

            $table->foreign('student_class_id')->references('id')->on('student_class');
            $table->foreign('teacher_course_id')->references('id')->on('teacher_course');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
