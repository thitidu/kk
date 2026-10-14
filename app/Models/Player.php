<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'position',
        'nationality',
        'shirt_number',
        'age',
        'goals',
        'assists',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}