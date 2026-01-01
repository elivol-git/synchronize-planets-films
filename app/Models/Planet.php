<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;
    protected $table = 'planets';
    protected $fillable = [
        'name',
        'rotation_period',
        'orbital_period',
        'diameter',
        'climate',
        'gravity',
        'terrain',
        'float',
        'population',
        'created',
        'edited',
        'url',
    ];

    protected $casts = [
        'population' => 'integer',
        'surface_water' => 'decimal:2',
        'rotation_period' => 'integer',
        'orbital_period' => 'integer',
        'diameter' => 'integer',
        'created' => 'datetime',
        'edited' => 'datetime',
    ];

    public function films(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_planet');
    }


}
