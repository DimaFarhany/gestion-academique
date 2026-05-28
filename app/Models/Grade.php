<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'enrollment_id',
        'grade',
        'type',
        'comment',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}