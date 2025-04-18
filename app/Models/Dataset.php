<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($datasetId)
 * @method static create(array $array)
 * @method static where(string $string, int|string|null $id)
 * @property mixed $file_path
 * @property mixed $name
 * @property mixed $is_approved
 * @property mixed $user_id
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
        'is_approved',
        'approved_at',
        'approved_by'
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
        return $this->size . ' MB';
    }

    public function files()
    {
        return $this->hasMany(DatasetFile::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
