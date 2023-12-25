<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rules\In;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['number','subtotal','tax','total','tva_id', 'user_id'];

    public function generateUniqueNumber()
    {
//        $lastFolder = Invoice::query()->latest()->get()->first();
//        if ($lastFolder) {
//            $id = $lastFolder->id + 1;
//        } else {
//            $id = 1;
//        }
        $id = Invoice::query()->count() + 1;
        $this->number = date('y') . str_pad($id, 3, '0', STR_PAD_LEFT) . '/IM' ;
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function tva(): BelongsTo
    {
        return $this->belongsTo(Tva::class);
    }

    public function amounts(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class);
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
