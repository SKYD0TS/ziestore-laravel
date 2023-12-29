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

    protected $columns = [
        'name' => [
            'rule' => 'required',
            'inputAttributes' => ['type' => 'text', 'label' => 'Name', 'name' => 'name'],
        ],
        "barcode" => [
            'rule' => "required|unique:App\Models\Product,barcode",
            'inputAttributes' => ['type' => 'text', 'label' => 'Barcode', 'name' => 'barcode'],
        ],
        "description" => [
            'rule' => "nullable",
            'inputAttributes' => ['type' => 'textbox', 'label' => 'Description', 'name' => 'description'],
        ],
        "category_id" => [
            'rule' => "required",
            'inputAttributes' => ['type' => 'select', 'label' => 'Category', 'name' => 'category_id', 'selections' => 'category'],
        ],
        "unit_id" => [
            'rule' => "required",
            'inputAttributes' => ['type' => 'select', 'label' => 'Unit', 'name' => 'unit_id', 'selections' => 'unit'],
        ],
        "stock" => [
            'rule' => "nullable",
            'inputAttributes' => ['type' => 'number', 'label' => 'Stock', 'name' => 'stock'],
        ],
        "price" => [
            'rule' => "required",
            'inputAttributes' => ['type' => 'number', 'label' => 'Price', 'name' => 'price'],
        ]
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
