<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryFile extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'delivery_files';

    protected $fillable = ['id', 'folder_id', 'bcm_file_path', 'bct_file_path'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
