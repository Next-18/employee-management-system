<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees'; // Table name

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birthday',
        'phone_number',
        'address',
        'gender',
        'salary',
        'profile_picture',
        'leave_balance',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }
}
