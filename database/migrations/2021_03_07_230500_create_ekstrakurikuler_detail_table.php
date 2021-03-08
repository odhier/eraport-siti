<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkstrakurikulerDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekstrakurikuler_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ekstrakurikuler_id')
            ->constrained('ekstrakurikuler')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('name');
            $table->string('nilai');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ekstrakurikuler_detail');
    }
}
