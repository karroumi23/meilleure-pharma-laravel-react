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
        // 'slug',

        // 'sku',
        'barcode',
        'dosage',

        'image',
        'description',

        'price',
        'sale_price',

        'stock',
        'minimum_stock',
        'expiry_date',

        'requires_prescription',
        'featured',

        'status',
        'rating',

        'is_active',
    ];

    protected $casts = [

        'requires_prescription'=>'boolean',
        'featured'=>'boolean',
        'is_active'=>'boolean',

        'expiry_date'=>'date',

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