<?php

namespace App\Models;

use App\Helpers\HasFile;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
//use Spatie\MediaLibrary\InteractsWithMedia;

class Payment extends Model
{
    use HasFactory;
    use HasFile;
    //use InteractsWithMedia;
    use Searchable;

    public const PATH = 'invoices';

    protected $fillable = [
        'folder_id',
        'invoice_number',
        'type',
        'amount',
    ];

    protected array $searchableFields = ['*'];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
