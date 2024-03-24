<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@eagora.app',
            'password' => bcrypt('123456789'),
        ]);

        $this->call([
            TypeSeeder::class,
            StateSeeder::class,
            ProcedureSeeder::class,
        ]);

        \App\Models\Procedure::factory(20)->create();

        \App\Models\Booking::factory(100)->create();
    }
}
