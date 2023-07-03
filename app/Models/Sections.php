<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'description',
        'created_by',
    ];

    public function product()
    {
        # code...
        return $this->hasMany(Products::class);
    }

    public function invoice()
    {
        # code...
        return $this->hasMany(Invoices::class);
    }


}