<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Play extends Model
{
    use HasFactory;
    protected $table = 'play';
    protected $fillable = [
        'diceOne',
        'diceTwo',
        'result',
        'user_id',
        
    ];

    /*public function player(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
*/

}
