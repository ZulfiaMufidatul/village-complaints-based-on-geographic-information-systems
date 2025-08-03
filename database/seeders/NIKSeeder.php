<?php

namespace Database\Seeders;

use App\Models\NIK;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NIKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nik = [
            '1234567890123451',
            '1234567890123452',
            '1234567890123453',
            '1234567890123454',
            '1234567890123455',
            '1234567890123456',
            '1234567890123457',
            '1234567890123458',
            '1234567890123459',
            '1234567890123460',
        ];

        foreach ($nik as $item) {
            NIK::create([
                'value' => $item
            ]);
        }
    }
}
