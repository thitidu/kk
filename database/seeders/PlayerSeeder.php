<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        // Snapshot retrieved on 2026-10-13 from the official FPL bootstrap and regions APIs.
        // Sources: fantasy.premierleague.com/api/bootstrap-static/ and /api/regions/.
        $players = json_decode(
            file_get_contents(__DIR__ . '/data/premier_league_2026_27_players.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if (count($players) !== 220) {
            throw new RuntimeException('The Premier League player snapshot must contain 220 players.');
        }

        $teams = Team::all()->keyBy('short_name');
        $playersByTeam = collect($players)->groupBy('team_short_name');

        if ($teams->count() !== 20 || $playersByTeam->count() !== 20) {
            throw new RuntimeException('The player snapshot must match all 20 Premier League clubs.');
        }

        DB::transaction(function () use ($teams, $playersByTeam) {
            foreach ($playersByTeam as $shortName => $squad) {
                $team = $teams->get($shortName);
                if (!$team || $squad->count() !== 11) {
                    throw new RuntimeException("The player snapshot must contain 11 players for {$shortName}.");
                }

                $names = $squad->pluck('name')->all();
                $team->players()->whereNotIn('name', $names)->delete();

                foreach ($squad as $player) {
                    Player::updateOrCreate(
                        ['team_id' => $team->id, 'name' => $player['name']],
                        [
                            'position' => $player['position'],
                            'nationality' => $player['nationality'],
                            'shirt_number' => $player['shirt_number'],
                            'age' => $player['age'],
                            'goals' => $player['goals'],
                            'assists' => $player['assists'],
                        ]
                    );
                }
            }
        });
    }
}
