<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        // Arsenal
        Player::create([
            'team_id' => 1,
            'name' => 'Bukayo Saka',
            'position' => 'Forward',
            'nationality' => 'England',
            'shirt_number' => 7,
            'age' => 25,
        ]);

        Player::create([
            'team_id' => 1,
            'name' => 'Martin Odegaard',
            'position' => 'Midfielder',
            'nationality' => 'Norway',
            'shirt_number' => 8,
            'age' => 27,
        ]);

        Player::create([
            'team_id' => 1,
            'name' => 'Declan Rice',
            'position' => 'Midfielder',
            'nationality' => 'England',
            'shirt_number' => 41,
            'age' => 27,
        ]);


        // Chelsea
        Player::create([
            'team_id' => 2,
            'name' => 'Cole Palmer',
            'position' => 'Midfielder',
            'nationality' => 'England',
            'shirt_number' => 10,
            'age' => 24,
        ]);

        Player::create([
            'team_id' => 2,
            'name' => 'Enzo Fernandez',
            'position' => 'Midfielder',
            'nationality' => 'Argentina',
            'shirt_number' => 8,
            'age' => 25,
        ]);

        Player::create([
            'team_id' => 2,
            'name' => 'Reece James',
            'position' => 'Defender',
            'nationality' => 'England',
            'shirt_number' => 24,
            'age' => 26,
        ]);


        // Liverpool
        Player::create([
            'team_id' => 3,
            'name' => 'Mohamed Salah',
            'position' => 'Forward',
            'nationality' => 'Egypt',
            'shirt_number' => 11,
            'age' => 34,
        ]);

        Player::create([
            'team_id' => 3,
            'name' => 'Virgil van Dijk',
            'position' => 'Defender',
            'nationality' => 'Netherlands',
            'shirt_number' => 4,
            'age' => 35,
        ]);

        Player::create([
            'team_id' => 3,
            'name' => 'Alisson Becker',
            'position' => 'Goalkeeper',
            'nationality' => 'Brazil',
            'shirt_number' => 1,
            'age' => 34,
        ]);


        // Manchester City
        Player::create([
            'team_id' => 4,
            'name' => 'Erling Haaland',
            'position' => 'Forward',
            'nationality' => 'Norway',
            'shirt_number' => 9,
            'age' => 26,
        ]);

        Player::create([
            'team_id' => 4,
            'name' => 'Phil Foden',
            'position' => 'Midfielder',
            'nationality' => 'England',
            'shirt_number' => 47,
            'age' => 26,
        ]);

        Player::create([
            'team_id' => 4,
            'name' => 'Kevin De Bruyne',
            'position' => 'Midfielder',
            'nationality' => 'Belgium',
            'shirt_number' => 17,
            'age' => 35,
        ]);
    }
}