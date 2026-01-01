<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'name',
        'height',
        'mass',
        'hair_color',
        'skin_color',
        'eye_color',
        'birth_year',
        'gender',
        'homeworld_id',
        'created',
        'edited',
        'url',
    ];

    protected $casts = [
        'height' => 'integer',
        'mass' => 'integer',
        'homeworld_id' => 'integer',
        'created' => 'datetime',
        'edited' => 'datetime',
    ];


    public function homeworld(): BelongsTo
    {
        return $this->belongsTo(Planet::class, 'homeworld_id');
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_person');
    }

    public function species(): BelongsToMany
    {
        return $this->belongsToMany(Species::class, 'person_species');
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'person_vehicle');
    }

    public function starships(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Starship::class, 'person_starship');
    }
}
