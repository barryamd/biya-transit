<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delivery extends Model
{
    use HasFactory;
    use HasFile;

    public const PATH = 'deliveries';

    protected $fillable = [
        'folder_id',
        'transporter_id',
        'delivery_date',
        'delivery_place',
        'exit_file_path',
        'return_file_path',
        'delivery_status',
        'customer_satisfaction',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'delivery_status' => 'boolean',
        'customer_satisfaction' => 'boolean',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function transporters(): BelongsToMany
    {
        return $this->belongsToMany(Transporter::class);
    }
}
