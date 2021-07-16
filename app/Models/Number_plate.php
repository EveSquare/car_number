<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number_plate extends Model
{
    use HasFactory;

    protected $fillable = [
        'regional_name',
        'category_number',
        'hiragana',
        'specified_number_1',
        'specified_number_2',
        'specified_number_3',
        'specified_number_4',
        'color',
        'is_Active',
        'is_Caution',
    ];

    // public function number_plate()
    // {
    //     $this->belongsTo(User::class);
    // }
}
