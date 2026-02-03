<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    // The table name (optional if it follows Laravel convention)
    protected $table = 'attendees';

    // Mass assignable attributes
    protected $fillable = [
        'fullName',
        'position',
        'type_attendee',
        'phone_number',
        'purpose',
        'company',
        'address',
        'photo',
        'attendance_date',
        'attendance_time',
    ];

    // Optional: cast date/time columns to proper types
    protected $casts = [
        'attendance_date' => 'date',
        'attendance_time' => 'datetime:H:i', // Only time portion
    ];

    // Optional: customize primary key or timestamps (not needed here)
    // public $primaryKey = 'id';
    // public $timestamps = true;
}
