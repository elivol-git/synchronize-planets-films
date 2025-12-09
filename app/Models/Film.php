<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = 'films';
    protected $guarded = [];
    protected $fillable = [
        'planet_id',
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
        'planet_id' => 'integer',
        'release_date' => 'date',
        'created' => 'datetime',
        'edited' => 'datetime',
    ];

    public function planet()
    {
        return $this->belongsTo(Planet::class);
    }

}
