<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Species extends Model
{
    use HasFactory;

    protected $table = 'species';

    protected $fillable = [
        'name',
        'classification',
        'designation',
        'average_height',
        'skin_colors',
        'hair_colors',
        'eye_colors',
        'average_lifespan',
        'homeworld_id',
        'language',
    ];

    public function homeworld(): BelongsTo
    {
        return $this->belongsTo(Planet::class, 'homeworld_id');
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_species', 'species_id', 'film_id');
    }

    public function people()
    {
        return $this->hasMany(Person::class, 'species_id');
    }
}
