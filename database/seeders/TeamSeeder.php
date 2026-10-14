<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            ['name' => 'Arsenal', 'short_name' => 'ARS', 'stadium' => 'Emirates Stadium', 'city' => 'London'],
            ['name' => 'Chelsea', 'short_name' => 'CHE', 'stadium' => 'Stamford Bridge', 'city' => 'London'],
            ['name' => 'Liverpool', 'short_name' => 'LIV', 'stadium' => 'Anfield', 'city' => 'Liverpool'],
            ['name' => 'Manchester City', 'short_name' => 'MCI', 'stadium' => 'Etihad Stadium', 'city' => 'Manchester'],
            ['name' => 'Aston Villa', 'short_name' => 'AVL', 'stadium' => 'Villa Park', 'city' => 'Birmingham'],
            ['name' => 'Bournemouth', 'short_name' => 'BOU', 'stadium' => 'Vitality Stadium', 'city' => 'Bournemouth'],
            ['name' => 'Brentford', 'short_name' => 'BRE', 'stadium' => 'Gtech Community Stadium', 'city' => 'London'],
            ['name' => 'Brighton & Hove Albion', 'short_name' => 'BHA', 'stadium' => 'Amex Stadium', 'city' => 'Brighton'],
            ['name' => 'Crystal Palace', 'short_name' => 'CRY', 'stadium' => 'Selhurst Park', 'city' => 'London'],
            ['name' => 'Everton', 'short_name' => 'EVE', 'stadium' => 'Hill Dickinson Stadium', 'city' => 'Liverpool'],
            ['name' => 'Fulham', 'short_name' => 'FUL', 'stadium' => 'Craven Cottage', 'city' => 'London'],
            ['name' => 'Leeds United', 'short_name' => 'LEE', 'stadium' => 'Elland Road', 'city' => 'Leeds'],
            ['name' => 'Manchester United', 'short_name' => 'MUN', 'stadium' => 'Old Trafford', 'city' => 'Manchester'],
            ['name' => 'Newcastle United', 'short_name' => 'NEW', 'stadium' => "St James' Park", 'city' => 'Newcastle upon Tyne'],
            ['name' => 'Nottingham Forest', 'short_name' => 'NFO', 'stadium' => 'The City Ground', 'city' => 'Nottingham'],
            ['name' => 'Sunderland', 'short_name' => 'SUN', 'stadium' => 'Stadium of Light', 'city' => 'Sunderland'],
            ['name' => 'Tottenham Hotspur', 'short_name' => 'TOT', 'stadium' => 'Tottenham Hotspur Stadium', 'city' => 'London'],
            ['name' => 'Coventry City', 'short_name' => 'COV', 'stadium' => 'Coventry Building Society Arena', 'city' => 'Coventry'],
            ['name' => 'Ipswich Town', 'short_name' => 'IPS', 'stadium' => 'Portman Road', 'city' => 'Ipswich'],
            ['name' => 'Hull City', 'short_name' => 'HUL', 'stadium' => 'MKM Stadium', 'city' => 'Kingston upon Hull'],
        ];

        foreach ($teams as $team) {
            Team::updateOrCreate(
                ['short_name' => $team['short_name']],
                $team
            );
        }
    }
}
