<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // vytvorim seba

        $me = User::factory()->create([
            'name' => 'Martin Cvinček',
            'email' => 'cvincmrt@gmail.com',
        ]);

        // vytvorim dalsich 3 kolegov

        $colleagues = User::factory(3)->create();

        // vytvorim 10 uloh ktore si zadal ty a riesia ich nahodny kolegovia

        Task::factory(10)->create([
            'creator_id' => $me->id,
            'assigned_to_id' => $colleagues->random()->id,
        ]);
    }
}
