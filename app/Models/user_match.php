<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_match extends Model
{
    use HasFactory;
    protected $fillable = [
        'diceOne',
        'diceTwo',
        'sum',
        'user_id',
        'match_id',
    ];
}
