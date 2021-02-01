<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_class_id')->unsigned();
            $table->integer('semester');
            $table->integer('sakit')->nullable()->default(0);
            $table->integer('izin')->nullable()->default(0);
            $table->integer('tanpa_keterangan')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('student_class_id')->references('id')->on('student_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}
