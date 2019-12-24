<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKredseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kredse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active')->default(false);
            $table->uuid('key')->nullable();
            $table->string('navn')->nullable();
            $table->string('website')->nullable();
            $table->string('stednavn')->nullable();
            $table->string('adresse')->nullable();
            $table->string('postnr')->nullable();
            $table->string('bynavn')->nullable();
            $table->decimal('latitude', 12, 9)->nullable();
            $table->decimal('longitude', 12, 9)->nullable();
            $table->string('kontakt_navn')->nullable();
            $table->string('kontakt_email')->nullable();
            $table->string('kontakt_telefon')->nullable();
            $table->text('billeder')->nullable();
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
        Schema::dropIfExists('kredse');
    }
}
