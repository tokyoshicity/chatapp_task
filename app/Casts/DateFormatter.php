<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DateFormatter implements CastsAttributes
{
    public function get($model, $key, $value, $attributes): ?string
    {
        return Carbon::parse($value)->format('d.m.Y H:i:s');
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
