<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionIn extends Model
{
    use HasFactory, ModelTrait;

    protected $rules = [
        'vendor_id' => 'required',
        'payment_type_id' => 'required',
    ];
}
