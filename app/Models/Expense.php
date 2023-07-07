<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'amount', 'description', 'folder_id'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
