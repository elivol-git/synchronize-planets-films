<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;
    protected $table = 'planets';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'rotation_period',
        'orbital_period',
        'diameter',
        'climate',
        'gravity',
        'terrain',
        'surface_water',
        'population',
        'created',
        'edited',
        'url',
    ];

    protected $casts = [
        'population' => 'integer',
        'surface_water' => 'integer',
        'rotation_period' => 'integer',
        'orbital_period' => 'integer',
        'diameter' => 'integer',
        'created' => 'datetime',
        'edited' => 'datetime',
    ];

    public function films()
    {
        return $this->hasMany(Film::class);
    }

}
