<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static findOrFail($fileId)
 */
class DatasetFile extends Model
{
    protected $fillable = [
        'dataset_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class);
    }
}
