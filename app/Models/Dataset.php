<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Dataset extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'skill_id',
        'industry_id',
        'year_id',
        'size',
        'file_path',
        'source'
    ];

    /**
     * Get the user that owns the dataset
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the skill associated with the dataset
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    /**
     * Get the industry associated with the dataset
     */
    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * Get the year associated with the dataset
     */
    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
