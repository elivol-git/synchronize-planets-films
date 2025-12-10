<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('planets', function (Blueprint $table) {
            $table->string('climate')->default('')->change();
            $table->string('gravity')->default('')->change();
            $table->string('terrain')->default('')->change();
            $table->string('url')->default('')->change();
            $table->timestamp('created')->nullable()->change();
            $table->timestamp('edited')->nullable()->change();
        });

        // Fix films table
        Schema::table('films', function (Blueprint $table) {
            $table->string('director')->default('')->change();
            $table->string('producer')->default('')->change();
            $table->string('url')->default('')->change();
            $table->timestamp('created')->nullable()->change();
            $table->timestamp('edited')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planets', function (Blueprint $table) {
            $table->string('climate')->change();
            $table->string('gravity')->change();
            $table->string('terrain')->change();
            $table->string('url')->change();
            $table->timestamp('created')->change();
            $table->timestamp('edited')->change();
        });

        Schema::table('films', function (Blueprint $table) {
            $table->string('director')->nullable()->change();
            $table->string('producer')->change();
            $table->string('url')->change();
            $table->timestamp('created')->change();
            $table->timestamp('edited')->change();
        });
    }
};
