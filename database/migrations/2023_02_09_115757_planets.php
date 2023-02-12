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
        if (!Schema::hasTable('planets')) {
            Schema::create('planets', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('rotation_period')->unsigned()->nullable();
                $table->integer('orbital_period')->unsigned()->nullable();
                $table->integer('diameter')->unsigned()->nullable();
                $table->string('climate');
                $table->string('gravity');
                $table->string('terrain');
                $table->integer('surface_water')->unsigned()->nullable();
                $table->bigInteger('population')->unsigned()->nullable();
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
    public function down()
    {
        Schema::dropIfExists('planets');
    }
};
