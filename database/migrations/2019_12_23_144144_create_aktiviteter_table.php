<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAktiviteterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktiviteter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('type')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('ikon')->nullable();
            $table->longText('indhold')->nullable();
            $table->longText('materialer')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktiviteter');
    }
}
