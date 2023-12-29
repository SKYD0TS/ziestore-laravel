<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory, ModelTrait;
    protected $guarded = ['id'];

    protected $columns = [
        'name' => [
            'rule' => 'required|unique:App\Models\PaymentType,name',
            'inputAttributes' => ['type' => 'text', 'label' => 'Name', 'name' => 'name'],
        ]
    ];

    protected $uniqueColumn = ['name'];
}
