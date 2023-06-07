<?php

namespace App\Models;

use App\Helpers\HasFile;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
//use Spatie\MediaLibrary\InteractsWithMedia;

class PurchaseInvoice extends Model
{
    use HasFactory;
    use HasFile;
    //use InteractsWithMedia;
    use Searchable;

    public const PATH = 'purchase_invoices';

    protected $fillable = [
        'folder_id',
        'invoice_number',
        'amount',
    ];

    protected array $searchableFields = ['*'];

    protected $table = 'purchase_invoices';

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
