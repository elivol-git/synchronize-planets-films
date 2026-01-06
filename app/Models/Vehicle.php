<?php

namespace App\Models;

use App\Models\Traits\NormalizeNumbers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    use HasFactory, NormalizeNumbers;

    protected $table = 'vehicles';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'model',
        'vehicle_class',
        'manufacturer',
        'cost_in_credits',
        'length',
        'crew',
        'passengers',
        'max_atmosphering_speed',
        'cargo_capacity',
        'consumables',
    ];

    public function setCostInCreditsAttribute($value): void
    {
        $this->attributes['cost_in_credits'] = $this->normalizeNumber($value);
    }

    public function setLengthAttribute($value): void
    {
        $this->attributes['length'] = $this->normalizeNumber($value);
    }

    public function setCrewAttribute($value): void
    {
        $this->attributes['crew'] = $this->normalizeNumber($value);
    }

    public function setPassengersAttribute($value): void
    {
        $this->attributes['passengers'] = $this->normalizeNumber($value);
    }
    public function setMaxAtmospheringSpeedAttribute($value): void
    {
        $this->attributes['max_atmosphering_speed'] = $this->normalizeNumber($value);
    }

    public function setCargoCapacityAttribute($value): void
    {
        $this->attributes['cargo_capacity'] = $this->normalizeNumber($value);
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_vehicle', 'vehicle_id', 'film_id');
    }

    public function pilots(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'person_vehicle', 'vehicle_id', 'person_id');
    }
}
