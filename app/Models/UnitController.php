<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitController extends Model
{
    use HasFactory;

    protected $table = 'controllers'; // <-- use the existing table
    protected $fillable = ['status'];

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }
}
