<?php

namespace App\Models\Transaction;

use App\Models\User\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetailOut extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $rules = [
        'staff_code' => 'required',
        'customer_code' => 'required',
    ];
    protected $uniqueColumn = [];

    public function generateId()
    {
        return strtoupper(bin2hex(random_bytes(1))) . date('y') . date('m') . date('d') . date('h') . date('s');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_code', 'id');
    }
}
