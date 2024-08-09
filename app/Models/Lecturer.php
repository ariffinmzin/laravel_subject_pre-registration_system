<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department',
        'lecturer_level'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
