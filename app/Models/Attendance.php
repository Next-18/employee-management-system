<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'approved',
    ];

    protected $casts = [
        'date' => 'date',
        'approved' => 'boolean',
    ];

    // Belongs to an employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
