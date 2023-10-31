<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FolderCharge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount', 'folder_id'];

    public $timestamps = false;

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
