<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DdiOpening extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'ddi_openings';

    protected $fillable = [
        'folder_id',
        'dvt_number',
        'dvt_obtained_date',
        'ddi_number',
        'ddi_obtained_date',
        'attach_file_path'
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
