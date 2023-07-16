<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['designation'];

    protected array $searchableFields = ['*'];

    public function folders(): BelongsToMany
    {
        return $this->belongsToMany(Folder::class);
    }

    public function exonerations(): BelongsToMany
    {
        return $this->belongsToMany(Exoneration::class);
    }
}
