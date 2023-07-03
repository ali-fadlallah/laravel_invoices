<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoices extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section_id',
        'discount',
        'amount_commission',
        'amount_collection',
        'rate_vat',
        'value_vat',
        'total',
        'status',
        'value_status',
        'notes',
        'user',
    ];

    public function section()
    {
        # code...
        return $this->belongsTo(Sections::class);
    }


}