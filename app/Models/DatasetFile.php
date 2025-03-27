<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
