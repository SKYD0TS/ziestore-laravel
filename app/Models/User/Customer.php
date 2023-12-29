<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelTrait;

class Customer extends Model
{
    use HasFactory, ModelTrait;

    protected $primaryKey = 'customer_code';
    protected $guarded = [];
    public $incrementing = false;

    protected $rules = [
        'name' => 'required',
        'phone' => 'nullable|min:9|max:15|unique:App\Models\Customer,phone'
    ];

    protected $uniqueColumn = ['phone'];

    public function generateId($name)
    {
        $initials = strtoupper(substr($name, 0, 1));
        $randomPart = strtoupper(bin2hex(random_bytes(2))); // Example: Generate a random 4-character hex string
        $customerCode = $initials . $randomPart;
        return $customerCode;
    }
}
