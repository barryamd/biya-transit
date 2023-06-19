<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Declaration extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'declarations';

    protected $fillable = [
        'folder_id',
        'number',
        'date',
        'destination_office',
        'verifier',
        'file_path',
        'liquidation_bulletin',
        'liquidation_date',
        'liquidation_file_path',
        'receipt_number',
        'receipt_date',
        'receipt_file_path'
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
