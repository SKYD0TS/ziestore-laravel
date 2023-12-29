<?php

namespace App\Models\Transaction;

use App\Models\ModelTrait;
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
