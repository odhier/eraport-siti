<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageKiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_ki', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_class_id')->unsigned();
            $table->integer('semester');
            $table->unsignedBigInteger('ki_id')->unsigned();
            $table->unsignedBigInteger('teacher_id')->unsigned();
            $table->longText('deskripsi');
            $table->timestamps();

            $table->foreign('student_class_id')->references('id')->on('student_class');
            $table->foreign('ki_id')->references('id')->on('kompetensi_inti');
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
        Schema::dropIfExists('message_ki');
    }
}
