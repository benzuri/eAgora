<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Pendiente'],
            ['name' => 'En progreso'],
            ['name' => 'Finalizado'],
        ];

        foreach ($items as $item) {
            DB::table('states')->insert($item);
        }
    }
}
