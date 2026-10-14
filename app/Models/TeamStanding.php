<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamStanding extends Model
{
    protected $fillable = [
        'team_id',
        'season',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
    ];

    protected $appends = ['points', 'goal_difference'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function getPointsAttribute(): int
    {
        return ($this->won * 3) + $this->drawn;
    }

    public function getGoalDifferenceAttribute(): int
    {
        return $this->goals_for - $this->goals_against;
    }
}
