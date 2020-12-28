<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_class_id')->unsigned();
            $table->integer('semester');
            $table->unsignedBigInteger('kd_id')->unsigned();
            $table->unsignedBigInteger('teacher_id')->unsigned();
            $table->float('NH', 8, 3)->nullable();
            $table->float('NUTS', 8, 3)->nullable();
            $table->float('NUAS', 8, 3)->nullable();
            $table->timestamps();


            $table->foreign('student_class_id')->references('id')->on('student_class');
            $table->foreign('kd_id')->references('id')->on('kompetensi_dasar');
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
        Schema::dropIfExists('nilai');
    }
}
