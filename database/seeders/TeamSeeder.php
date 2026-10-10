<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::create([
            'name' => 'Arsenal',
            'short_name' => 'ARS',
            'stadium' => 'Emirates Stadium',
            'city' => 'London',
        ]);

        Team::create([
            'name' => 'Chelsea',
            'short_name' => 'CHE',
            'stadium' => 'Stamford Bridge',
            'city' => 'London',
        ]);

        Team::create([
            'name' => 'Liverpool',
            'short_name' => 'LIV',
            'stadium' => 'Anfield',
            'city' => 'Liverpool',
        ]);

        Team::create([
            'name' => 'Manchester City',
            'short_name' => 'MCI',
            'stadium' => 'Etihad Stadium',
            'city' => 'Manchester',
        ]);
    }
}