<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['number','subtotal','tax','total','tva_id'];

    public function generateUniqueNumber()
    {
        $lastFolder = Invoice::query()->latest()->get()->first();
        if ($lastFolder) {
            $id = $lastFolder->id + 1;
        } else {
            $id = 1;
        }
        $this->number = date('y') . str_pad($id, 3, '0', STR_PAD_LEFT) . '/IM' ;
    }

    public function tva(): BelongsTo
    {
        return $this->belongsTo(Tva::class);
    }

    public function amounts(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }
}
