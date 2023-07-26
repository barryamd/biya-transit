<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryNote extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'delivery_notes';

    protected $fillable = ['id', 'folder_id', 'container_id', 'bcm', 'bct', 'bcm_file_path', 'bct_file_path'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }
}
