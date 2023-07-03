<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachments extends Model
{
    use HasFactory;

    protected $fillable = [

        'fileName',
        'invoice_id',
        'invoice_number',
        'Created_by',
    ];

}