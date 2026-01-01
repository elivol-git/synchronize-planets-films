<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = 'films';
    protected $fillable = [
        'title',
        'episode_id',
        'opening_crawl',
        'director',
        'producer',
        'release_date',
        'created',
        'edited',
        'url',
    ];

    protected $casts = [
        'release_date' => 'date:Y-m-d',
        'created' => 'datetime',
        'edited' => 'datetime',
    ];

    public function planets(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Planet::class, 'film_planet');
    }

}
