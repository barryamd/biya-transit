<?php

namespace App\Models;

use App\Helpers\HasFile;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;
    use HasFile;
    use Searchable;

    public const PATH = 'deliveries';

    protected $fillable = [
        'folder_id',
        'transporter_id',
        'delivery_date',
        'delivery_place',
        'attach_file',
        'delivery_status',
        'customer_satisfaction',
    ];

    protected array $searchableFields = ['*'];

    protected $casts = [
        'delivery_date' => 'date',
        'delivery_status' => 'boolean',
        'customer_satisfaction' => 'boolean',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function transporter(): BelongsTo
    {
        return $this->belongsTo(Transporter::class);
    }
}
