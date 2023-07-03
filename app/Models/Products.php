<?php

namespace App\Models;

use App\Models\Sections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'description',
        'section_id',
    ];

    public function section()
    {
        # code...
        return $this->belongsTo(Sections::class);
    }

}