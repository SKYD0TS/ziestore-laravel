<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory, ModelTrait;
    protected $guarded = ['id'];

    protected $rules = [
        'name' => 'required|unique:App\Models\PaymentType,name'
    ];
    protected $uniqueColumn = ['name'];
}
