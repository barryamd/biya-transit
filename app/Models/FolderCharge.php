<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FolderCharge extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'amount', 'folder_id', 'user_id'];

    public $timestamps = false;

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
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
