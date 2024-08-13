<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public const CREDIT_OPTIONS = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
    ];

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
        'Faculty' => 'Faculty',
        'CLS' => 'CLS',
        'PPUK' => 'PPUK',
    ];

    protected $fillable = [
        'subject_code',
        'subject_name',
        'subject_credit',
        'subject_program',
        'subject_year',
        'status',
    ];
}
