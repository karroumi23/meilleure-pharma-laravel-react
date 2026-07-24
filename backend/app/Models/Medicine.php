<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'barcode',
        'dosage',
        'image',
        'description',
        'price',
        'sale_price',
        'requires_prescription',
        'status',
        'sku',
        'rating',
    ];

    protected $casts = [
        'requires_prescription' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'rating' => 'float',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}