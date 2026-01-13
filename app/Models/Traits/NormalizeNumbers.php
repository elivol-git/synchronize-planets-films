<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait NormalizeNumbers
{
    protected static function bootNormalizeNumbers(): void
    {
        static::saving(function (Model $model) {
            if (! method_exists($model, 'numeric')) {
                return;
            }

            foreach ($model->numeric() as $field) {
                $model->{$field} = $model->normalizeNumber($model->{$field});
            }
        });
    }


    protected function normalizeNumber($value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
    }
}
