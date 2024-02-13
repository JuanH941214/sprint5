<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchResults extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'winRate'];
    protected $table = 'matchResults';

}
