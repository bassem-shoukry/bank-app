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

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;

        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }
}
