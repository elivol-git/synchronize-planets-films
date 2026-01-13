<?php

namespace App\Services\Swapi;

class SwapiUrlRegistry
{
    protected array $seen = [];

    public function remember(string $url): bool
    {
        if (isset($this->seen[$url])) {
            return false;
        }

        $this->seen[$url] = true;
        return true;
    }
}
