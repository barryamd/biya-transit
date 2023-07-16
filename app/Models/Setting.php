<?php

namespace App\Models;

use App\Helpers\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    use HasFile;

    protected $fillable = [
        'name', 'acronym', 'logo', 'signature', 'email', 'phone', 'phone2', 'phone3', 'address',
        'holder', 'bic', 'iban', 'bank', 'bank_address'
    ];

    public $timestamps = false;

    public function getTaxAmount($amount)
    {
        return $this->tax*$amount;
    }

    public function getAmountWithTax($amount)
    {
        return $amount+$this->getTaxAmount($amount);
    }

    protected function photoDisk(): string
    {
        return  'public_2';
    }

    protected function getPhotoPath(): string
    {
        return 'settings';
    }
}
