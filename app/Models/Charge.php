<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Charge extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'charges';

    protected $fillable = ['type', 'name', 'amount', 'period', 'attach_file_path', 'details'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
