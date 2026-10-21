<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAktivitetKredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitet_kreds', function (Blueprint $table) {
            $table->unsignedBigInteger('aktivitet_id');
            $table->unsignedBigInteger('kreds_id');

            $table->unique(['aktivitet_id', 'kreds_id']);
            $table->foreign('aktivitet_id')->references('id')->on('aktiviteter')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kreds_id')->references('id')->on('kredse')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktivitet_kreds');
    }
}
