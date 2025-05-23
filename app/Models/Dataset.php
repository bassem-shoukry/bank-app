<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @method static create(array $array)
 */
class Dataset extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'author',
        'industry_id',
        'year_id',
        'size',
        'file_path',
        'source',
        'is_approved',
        'approved_at',
        'approved_by',
        'communications_opt_in',
    ];


    // Skills (many-to-many)
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'dataset_skill');
    }

    // Get all skills
    public function getAllSkills(): Collection
    {
        return $this->skills;
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function files(): HasMany
    {
        return $this->hasMany(DatasetFile::class);
    }

    // Format file size for display
    public function formatSize(): string
    {
        if ($this->size < 1) {
            return round($this->size * 1024) . ' KB';
        }
        return $this->size . ' MB';
    }
}
