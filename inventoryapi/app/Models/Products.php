<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'ProductName',
            'SKU',
            'Description',
            'UnitsInInventory',
            'MinStockLevel',
            'Price',
            'Image',
            'categories_id'
        ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
