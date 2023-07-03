<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'product',
        'sections',
        'status',
        'value_status',
        'note',
        'user',
        'invoice_id',
    ];
}