<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory, ModelTrait;

    protected $guarded = ['id'];

    protected $rules = [
        'name' => 'required|unique:App\Models\Category,name'
    ];
    protected $uniqueColumn = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'unit_id', 'id');
    }
}
