<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Play extends Model
{
    use HasFactory;
    protected $table = 'play';
    protected $fillable = [
        'diceOne',
        'diceTwo',
        'sum',
        'user_id',
        'match_id',
    ];
}
