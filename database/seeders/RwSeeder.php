<?php

namespace Database\Seeders;

use App\Models\Hamlet;
use App\Models\RW;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // mapping jumlah RW per dusun
        $mapping = [
            'Tegalsari'  => ['RW 01'],
            'Kemiri'     => ['RW 02'],
            'Donowarih'  => ['RW 03'],
            'Ngares'     => ['RW 03', 'RW 04'],
            'Tempuran'   => ['RW 05', 'RW 06'],
            'Bulakan'    => ['RW 07', 'RW 11'],
            'Tlogorejo'  => ['RW 08'],
            'Tegalrejo'  => ['RW 08'],
            'Kauman'     => ['RW 09'],
            'Kebonwetan' => ['RW 09'],
            'Gesingan'   => ['RW 10'],
        ];


        foreach ($mapping as $hamletName => $rwNames) {
            $hamlet = Hamlet::where('name', $hamletName)->first();

            if ($hamlet) {
                foreach ($rwNames as $rwName) {
                    Rw::firstOrCreate([
                        'hamlet_id' => $hamlet->id,
                        'name' => $rwName,
                    ]);
                }
            }
        }
    }
}
