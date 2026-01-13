<?php

namespace App\Services\Swapi\Concerns;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait SwapiHelpers
{
    protected function fetchJsonWithCache(string $url): ?array
    {
        $cacheKey = "swapi:$url";

        if ($cached = Cache::get($cacheKey)) {
            return json_decode($cached, true);
        }

        try {
            $response = $this->client->get($url);

            if ($response->getStatusCode() !== 200) {
                throw new \RuntimeException(
                    "SWAPI returned status {$response->getStatusCode()}"
                );
            }

            $body = $response->getBody()->getContents();
            Cache::put($cacheKey, $body, 3600);

            return json_decode($body, true);
        } catch (\Throwable $e) {
            Log::error('SWAPI fetch failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    protected function assertValidJson(array $json): void
    {
        if (!isset($json['results']) || !is_array($json['results'])) {
            throw new \RuntimeException('Invalid SWAPI JSON structure');
        }
    }

    protected function extractIdFromUrl(?string $url): ?int
    {
        if (!$url) {
            return null;
        }

        return (int) basename(rtrim($url, '/'));
    }

    protected function getNextPage(?string $pageUrl): ?array
    {
        if(!empty($pageUrl)) {
            $page = $this->fetchJsonWithCache($pageUrl);
            if(!$page) {
                throw new \RuntimeException('Data fetch failed: '.$pageUrl);
            }
            $this->assertValidJson($page);
        } else {
            $page = null;
        }

        return $page;
    }

}
