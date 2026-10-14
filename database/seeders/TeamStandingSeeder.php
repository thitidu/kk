<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\TeamStanding;
use Illuminate\Database\Seeder;

class TeamStandingSeeder extends Seeder
{
    private const SEASON = '2026/27';

    public function run(): void
    {
        $sampleStandings = [
            'ARS' => [86, 79, 34],
            'MCI' => [80, 75, 38],
            'LIV' => [77, 73, 42],
            'CHE' => [70, 68, 45],
            'AVL' => [66, 62, 49],
            'TOT' => [64, 65, 54],
            'MUN' => [60, 58, 50],
            'NEW' => [58, 60, 55],
            'BHA' => [55, 56, 54],
            'BRE' => [52, 54, 52],
            'CRY' => [49, 48, 47],
            'FUL' => [47, 46, 48],
            'EVE' => [45, 42, 48],
            'NFO' => [43, 43, 50],
            'BOU' => [42, 47, 57],
            'LEE' => [40, 44, 58],
            'SUN' => [38, 39, 55],
            'COV' => [35, 37, 58],
            'IPS' => [29, 35, 65],
            'HUL' => [24, 32, 71],
        ];

        foreach ($sampleStandings as $shortName => [$points, $goalsFor, $goalsAgainst]) {
            $team = Team::where('short_name', $shortName)->firstOrFail();
            $drawn = $points % 3;
            $won = intdiv($points - $drawn, 3);

            TeamStanding::updateOrCreate(
                ['team_id' => $team->id, 'season' => self::SEASON],
                [
                    'played' => 38,
                    'won' => $won,
                    'drawn' => $drawn,
                    'lost' => 38 - $won - $drawn,
                    'goals_for' => $goalsFor,
                    'goals_against' => $goalsAgainst,
                ]
            );
        }
    }
}
