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
        'declaration_file_path',
        'liquidation_bulletin',
        'liquidation_date',
        'liquidation_file_path',
        'receipt_number',
        'receipt_date',
        'receipt_file_path',
        'bon_number',
        'bon_date',
        'bon_file_path',
        'user_id'
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function author(): BelongsTo
    {
        return $this->user();
    }
}
