<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up():void
    {
        if (!Schema::hasTable('films')) {

            Schema::create('films', function (Blueprint $table) {
                $table->id();
                $table->foreignId('planet_id')->constrained('planets');
                $table->string('title');
                $table->integer('episode_id');
                $table->text('opening_crawl');
                $table->string('director')->nullable();
                $table->string('producer');
                $table->date('release_date');
                $table->timestamp('created');
                $table->timestamp('edited');
                $table->string('url');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down():void
    {
        Schema::dropIfExists('films');
    }
};
