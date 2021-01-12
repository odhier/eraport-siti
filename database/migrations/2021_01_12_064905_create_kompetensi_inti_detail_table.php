<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetensiIntiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensi_inti_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ki_id')->unsigned();
            $table->string('kompetensi');
            $table->timestamps();

            $table->foreign('ki_id')->references('id')->on('kompetensi_inti');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kompetensi_inti_detail');
    }
}
