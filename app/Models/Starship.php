<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Starship extends Model
{
    use HasFactory;

    protected $table = 'starships';

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

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_starship', 'starship_id', 'film_id');
    }

    public function pilots(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'person_starship', 'starship_id', 'person_id');
    }
}
