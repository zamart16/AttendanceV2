<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit',
        'controller_id',
    ];

    public function controller()
    {
        return $this->belongsTo(Controller::class);
    }
}
