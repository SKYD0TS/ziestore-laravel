<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, ModelTrait;
    protected $guarded = [];
    protected $with = ['category', 'unit'];
    protected $primaryKey = 'barcode';

    protected $rules = [
        "barcode" => "required|unique:App\Models\Product,barcode",
        "name" => "required",
        "description" => "nullable",
        "category_id" => "required",
        "unit_id" => "required",
        "stock" => "nullable",
        "price" => "required"
    ];
    protected $uniqueColumn = ['barcode'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
