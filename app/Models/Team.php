<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'stadium',
        'city'
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function standings()
    {
        return $this->hasMany(TeamStanding::class);
    }
}