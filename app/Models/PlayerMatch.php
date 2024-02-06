<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class player_match extends Model
{
    use HasFactory;
    protected $table = 'player_match';
    protected $fillable = [
        'diceOne',
        'diceTwo',
        'sum',
        'user_id',
        'match_id',
    ];
}
