<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controller extends Model
{
    use HasFactory;

    protected $table = 'controllers'; // 👈 FIX HERE

    protected $fillable = [
        'status',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
