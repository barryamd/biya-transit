<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'bank', 'date', 'check_number', 'amount', 'note', 'invoice_id', 'folder_id', 'user_id'
    ];

    public $timestamps = false;

    public function getDetailsAttribute(): string
    {
        $payments = [
            'espece' => 'Paiement en espèce',
            'cheque' => 'Paiement par chèque',
            'virement' => 'Paiement par virement',
            'terme' => 'Paiement à terme',
        ];
        $details = $payments[$this->type];
        if ($this->type == 'cheque') {
            $details .= ' .N° ' . $this->check_number.', date emission'.dateFormat($this->date);
        } elseif ($this->type == 'cheque') {
            $details .= ', Date execution'.dateFormat($this->date);
        } elseif ($this->bank) {
            $details .= '. Bank: ' . $this->bank;
        }
        return $details;
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
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
