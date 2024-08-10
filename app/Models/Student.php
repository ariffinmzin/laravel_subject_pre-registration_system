<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // left - database
    // right - frontend

    public const YEAR_OPTIONS = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
    ];  
      
    public const PROGRAM_OPTIONS = [
        'BIT' => 'BIT',
        'BIP' => 'BIP',
        'BIS' => 'BIS',
        'BIW' => 'BIW',
        'BIM' => 'BIM',
    ];


    protected $fillable = [
        'user_id',
        'lecturer_id',
        'year_of_study',
        'program',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}
