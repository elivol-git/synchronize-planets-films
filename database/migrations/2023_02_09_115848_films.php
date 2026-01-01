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
                $table->string('title')->index();
                $table->unsignedTinyInteger('episode_id')->index();
                $table->text('opening_crawl');
                $table->string('director')->default('')->nullable();
                $table->string('producer')->default('');
                $table->date('release_date');
                $table->timestamp('created')->nullable();
                $table->timestamp('edited')->nullable();
                $table->string('url')->default('');
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
