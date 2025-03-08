<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(int[] $array)
 */
class Year extends Model
{
    use HasFactory;

    protected $fillable = ['year'];

    /**
     * Get the datasets published in this year
     */
    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }
}
