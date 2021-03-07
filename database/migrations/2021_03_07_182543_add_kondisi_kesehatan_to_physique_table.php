<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKondisiKesehatanToPhysiqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('physique', function (Blueprint $table) {
            $table->string('pendengaran')->nullable();
            $table->string('penglihatan')->nullable();
            $table->string('gigi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('physique', function (Blueprint $table) {
            //
        });
    }
}
