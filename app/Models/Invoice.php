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
        $lastInvoiceNumber = Invoice::query()->latest('number')->select('number')->get()->first()->number ?? 0;
        if (str_starts_with($lastInvoiceNumber, date('y'))) {
            $id = (int)substr($lastInvoiceNumber,2) + 1; //24001
        } else {
            $id = 1;
        }
        $this->number = date('y') . str_pad($id,3,'0',STR_PAD_LEFT);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function tva(): BelongsTo
    {
        return $this->belongsTo(Tva::class);
    }

    public function charges(): HasMany
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
