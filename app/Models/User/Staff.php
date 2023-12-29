<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ModelTrait;

    protected $primaryKey = 'staff_code';
    protected $guarded = [];
    public $incrementing = false;

    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }


    protected $rules = [
        'name' => 'required',
        'email' => 'required|unique:App\Models\Staff,email',
        'role' => 'required|in:owner,operator,cashier',
        'password' => 'required'
    ];

    protected $uniqueColumn = ['email'];

    public function generateId($role)
    {
        return strtoupper(substr($role, 0, 1)) . date('ymdis');
    }

    public function hasRole(string $role)
    {
        return $this->role == $role;
    }
}
