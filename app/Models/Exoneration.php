<?php

namespace App\Models;

use App\Helpers\HasFile;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exoneration extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'exonerations';

    protected $fillable = ['folder_id', 'number', 'date', 'responsible', 'user_id'];

    protected $casts = [
        'date' => 'string'
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
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
