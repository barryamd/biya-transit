<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Container extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'folder_id',
        'number',
        'weight',
        'package_number',
        'arrival_date',
    ];

    protected array $searchableFields = ['*'];

    protected $casts = [
        'filling_date' => 'date',
        'arrival_date' => 'date',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
