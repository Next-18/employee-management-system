<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees';

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

    // Link to User
    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }

    // ✅ Link to Attendances (required for attendance summary)
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
