<?php

namespace App\Models\Traits;

trait NormalizeNumbers
{
    protected function normalizeNumber($value)
    {
        if (is_null($value) || strtolower($value) === 'unknown') {
            return null;
        }
        $number = preg_replace('/[^0-9.]/', '', $value);
        return $number !== '' ? (float)$number : null;
    }
}
