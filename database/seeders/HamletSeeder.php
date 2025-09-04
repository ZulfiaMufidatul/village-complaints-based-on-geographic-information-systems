<?php

namespace Database\Seeders;

use App\Models\Hamlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HamletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hamlets = [
            'Bulakan',
            'Gesingan',
            'Kauman',
            'Kebonwetan',
            'Kemiri',
            'Ngares',
            'Tegalsari',
            'Tempuran',
            'Tlogorejo',
            'Tegalrejo',
            'Donowarih',
        ];

        foreach ($hamlets as $hamlet) {
            Hamlet::firstOrCreate([
                'name' => $hamlet,
            ]);
        }
    }
}
