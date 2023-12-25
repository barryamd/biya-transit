<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Container extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'folder_id',
        'type_id',
        'number',
        'weight',
        'package_number',
        'arrival_date',
        'transporter_id',
        'user_id'
    ];

    protected array $searchableFields = ['*'];

    protected $casts = [
        'filling_date' => 'string',
        'arrival_date' => 'string',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ContainerType::class, 'type_id');
    }

    public function transporter(): BelongsTo
    {
        return $this->belongsTo(Transporter::class);
    }

    public function exoneration(): HasOne
    {
        return $this->hasOne(Exoneration::class);
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
