<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Evento'],
            ['name' => 'Inscripción'],
            ['name' => 'Bono'],
            ['name' => 'Pago'],
        ];

        foreach ($items as $item) {
            DB::table('types')->insert($item);
        }
    }
}
