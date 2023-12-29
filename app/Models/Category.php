<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, ModelTrait;

    protected $guarded = ['id'];

    protected $columns = [
        'name' => [
            'rule' => 'required|unique:App\Models\Category,name',
            'inputAttributes' => ['type' => 'text', 'label' => 'Name', 'name' => 'name'],
        ]
    ];

    protected $uniqueColumn = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
