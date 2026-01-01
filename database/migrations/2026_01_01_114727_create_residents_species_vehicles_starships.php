<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (!Schema::hasTable('people')) {
            Schema::create('people', function (Blueprint $table) {
                $table->id();
                $table->string('name')->index();
                $table->unsignedInteger('height')->nullable();
                $table->unsignedInteger('mass')->nullable();
                $table->string('hair_color')->nullable();
                $table->string('skin_color')->nullable();
                $table->string('eye_color')->nullable();
                $table->string('birth_year')->nullable();
                $table->string('gender')->nullable();
                $table->string('homeworld')->nullable();
                $table->timestamp('created')->nullable();
                $table->timestamp('edited')->nullable();
                $table->string('url');
                $table->foreignId('homeworld_id')->nullable()->constrained('planets');
            });
        }

        if (!Schema::hasTable('species')) {
            Schema::create('species', function (Blueprint $table) {
                $table->id();
                $table->foreignId('planet_id')->constrained('planets');
                $table->string('name')->index();
                $table->unsignedInteger('classification')->nullable();
                $table->unsignedInteger('designation')->nullable();
                $table->unsignedInteger('average_height')->nullable();
                $table->string('skin_colors')->nullable();
                $table->string('hair_colors')->nullable();
                $table->string('eye_colors')->nullable();
                $table->unsignedInteger('average_lifespan')->nullable();
                $table->string('homeworld')->nullable();
                $table->string('language')->nullable();
                $table->timestamp('created')->nullable();
                $table->timestamp('edited')->nullable();
                $table->string('url');
                $table->foreignId('homeworld_id')->nullable()->index()->constrained('planets');
            });
        }

        if (!Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->index();
                $table->string('model')->nullable();
                $table->string('manufacturer')->nullable();
                $table->unsignedInteger('cost_in_credits')->nullable();
                $table->float('length')->unsigned()->nullable();
                $table->unsignedInteger('max_atmosphering_speed')->nullable();
                $table->unsignedInteger('crew')->nullable();
                $table->unsignedInteger('passengers')->nullable();
                $table->unsignedInteger('cargo_capacity')->nullable();
                $table->string('consumables')->nullable();
                $table->string('vehicle_class')->nullable();
                $table->timestamp('created')->nullable();
                $table->timestamp('edited')->nullable();
                $table->string('url')->nullable();
            });
        }

        if (!Schema::hasTable('starships')) {
            Schema::create('starships', function (Blueprint $table) {
                $table->id();
                $table->string('name')->index();
                $table->string('model')->nullable();
                $table->string('manufacturer')->nullable();
                $table->unsignedInteger('cost_in_credits')->nullable();
                $table->decimal('length', 6, 2)->unsigned()->nullable();
                $table->unsignedInteger('max_atmosphering_speed')->nullable();
                $table->unsignedInteger('crew')->nullable();
                $table->unsignedInteger('passengers')->nullable();
                $table->unsignedInteger('cargo_capacity')->nullable();
                $table->string('consumables')->nullable();
                $table->decimal('hyperdrive_rating', 3, 1)->unsigned()->nullable();
                $table->unsignedInteger('MGLT')->nullable();
                $table->string('starship_class')->nullable();
                $table->timestamp('created');
                $table->timestamp('edited');
                $table->string('url');
            });
        }

        //Pivot tables
        if (!Schema::hasTable('film_planet')) {
            Schema::create('film_planet', function (Blueprint $table) {
                $table->foreignId('film_id')->constrained()->cascadeOnDelete();
                $table->foreignId('planet_id')->constrained()->cascadeOnDelete();
                $table->primary(['film_id', 'planet_id']);
                $table->index(['planet_id', 'film_id']);
            });
        }

        if (!Schema::hasTable('film_person')) {
            Schema::create('film_person', function (Blueprint $table) {
                $table->foreignId('film_id')->constrained()->cascadeOnDelete();
                $table->foreignId('person_id')->constrained()->cascadeOnDelete();
                $table->primary(['film_id', 'person_id']);
                $table->index(['person_id', 'film_id']);
            });
        }

        if (!Schema::hasTable('film_species')) {
            Schema::create('film_species', function (Blueprint $table) {
                $table->foreignId('film_id')->constrained()->cascadeOnDelete();
                $table->foreignId('species_id')->constrained()->cascadeOnDelete();
                $table->primary(['film_id', 'species_id']);
                $table->index(['species_id', 'film_id']);
            });
        }

        if (!Schema::hasTable('film_vehicle')) {
            Schema::create('film_vehicle', function (Blueprint $table) {
                $table->foreignId('film_id')->constrained()->cascadeOnDelete();
                $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
                $table->primary(['film_id', 'vehicle_id']);
                $table->index(['vehicle_id', 'film_id']);
            });
        }

        if (!Schema::hasTable('film_starship')) {
            Schema::create('film_starship', function (Blueprint $table) {
                $table->foreignId('film_id')->constrained()->cascadeOnDelete();
                $table->foreignId('starship_id')->constrained()->cascadeOnDelete();

                $table->primary(['film_id', 'starship_id']);
            });
        }

        if (!Schema::hasTable('person_species')) {
            Schema::create('person_species', function (Blueprint $table) {
                $table->foreignId('person_id')->constrained()->cascadeOnDelete();
                $table->foreignId('species_id')->constrained()->cascadeOnDelete();
                $table->primary(['person_id', 'species_id']);
                $table->index(['species_id', 'person_id']);
            });
        }

        if (!Schema::hasTable('person_vehicle')) {
            Schema::create('person_vehicle', function (Blueprint $table) {
                $table->foreignId('person_id')->constrained()->cascadeOnDelete();
                $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
                $table->primary(['person_id', 'vehicle_id']);
                $table->index(['vehicle_id', 'person_id']);
            });
        }

        if (!Schema::hasTable('person_starship')) {
            Schema::create('person_starship', function (Blueprint $table) {
                $table->foreignId('person_id')->constrained()->cascadeOnDelete();
                $table->foreignId('starship_id')->constrained()->cascadeOnDelete();
                $table->primary(['person_id', 'starship_id']);
                $table->index(['starship_id', 'person_id']);
            });
        }

    }

    public function down(): void
    {
        Schema::dropIfExists('person_starship');
        Schema::dropIfExists('person_vehicle');
        Schema::dropIfExists('person_species');

        Schema::dropIfExists('film_starship');
        Schema::dropIfExists('film_vehicle');
        Schema::dropIfExists('film_species');
        Schema::dropIfExists('film_person');
        Schema::dropIfExists('film_planet');

        Schema::dropIfExists('starships');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('species');
        Schema::dropIfExists('people');
    }
};
