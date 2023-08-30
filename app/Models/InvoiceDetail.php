<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'amount', 'benefit'];

    public $timestamps = false;

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
