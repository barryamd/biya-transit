<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'folders';

    protected $fillable = ['folder_id','type_id','number','attach_file_path'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'type_id');
    }
}
