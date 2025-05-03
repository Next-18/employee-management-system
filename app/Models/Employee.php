<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees'; // Table name

    protected $fillable = ['FirstName', 'MiddleName', 'LastName', 'Suffix', 'Birthday','PhoneNumber', 'Address', 'Gender', 'Salary']; 
}
