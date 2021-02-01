<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_class_id')->unsigned();
            $table->integer('semester');
            $table->unsignedBigInteger('teacher_id')->unsigned();
            $table->longText('saran');
            $table->timestamps();

            $table->foreign('student_class_id')->references('id')->on('student_class');
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
        Schema::dropIfExists('saran');
    }
}
