<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $value)
 */
class City extends Model
{
    protected $guarded= [];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
