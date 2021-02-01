<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiKiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ki', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_class_id')->unsigned();
            $table->integer('semester');
            $table->unsignedBigInteger('ki_detail_id')->unsigned();
            $table->unsignedBigInteger('teacher_id')->unsigned();
            $table->integer('value')->nullable();
            $table->timestamps();


            $table->foreign('student_class_id')->references('id')->on('student_class');
            $table->foreign('ki_detail_id')->references('id')->on('kompetensi_inti_detail');
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
        Schema::dropIfExists('nilai_ki');
    }
}
