<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static pluck(string $string, string $string1)
 */
class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Get the datasets that belong to this skill
     */
    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }
}
