<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($datasetId)
 * @method static create(array $array)
 * @property mixed $file_path
 * @property mixed $name
 */
class Dataset extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'skill_id',
        'industry_id',
        'year_id',
        'size',
        'file_path',
    ];

    /**
     * Get the skill associated with the dataset.
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    /**
     * Get the industry associated with the dataset.
     */
    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * Get the year associated with the dataset.
     */
    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    /**
     * Format the size to be more human-readable
     */
    public function formatSize(): string
    {
        $size = $this->size;

        if (!$size) {
            return 'Unknown';
        }

        // Convert to MB (divide by 1024^2)
        $sizeInMB = $size / 1048576;

        // Return with MB unit
        return round($sizeInMB, 2) . ' MB';
    }

    public function files()
    {
        return $this->hasMany(DatasetFile::class);
    }
}
