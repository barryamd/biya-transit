<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exoneration extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['folder_id', 'amount'];

    protected array $searchableFields = ['*'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
