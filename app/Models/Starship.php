<?php

namespace App\Models;

use App\Models\Traits\NormalizeNumbers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Starship extends Model
{
    use HasFactory, NormalizeNumbers;

    protected $table = 'starships';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'model',
        'starship_class',
        'manufacturer',
        'cost_in_credits',
        'length',
        'crew',
        'passengers',
        'max_atmosphering_speed',
        'hyperdrive_rating',
        'MGLT',
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

    public function setHyperdriveRatingAttribute($value): void
    {
        $this->attributes['hyperdrive_rating'] = $this->normalizeNumber($value);
    }

    public function setMGLTAttribute($value): void
    {
        $this->attributes['MGLT'] = $this->normalizeNumber($value);
    }

    public function setCargoCapacityAttribute($value): void
    {
        $this->attributes['cargo_capacity'] = $this->normalizeNumber($value);
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_starship', 'starship_id', 'film_id');
    }

    public function pilots(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'person_starship', 'starship_id', 'person_id');
    }
}
