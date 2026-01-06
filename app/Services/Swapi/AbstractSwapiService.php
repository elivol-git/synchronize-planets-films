<?php

namespace App\Services\Swapi;

use GuzzleHttp\Client;
use App\Services\Swapi\Concerns\SwapiHelpers;

abstract class AbstractSwapiService
{
    use SwapiHelpers;

    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'http_errors' => false,
            'verify' => false,
        ]);
    }
}
