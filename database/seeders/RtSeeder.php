<?php

namespace Database\Seeders;

use App\Models\RT;
use App\Models\RW;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapping = [
            'Tegalsari|RW 01'  => ['RT 01', 'RT 02', 'RT 03'],
            'Gesingan|RW 10'   => ['RT 01', 'RT 02', 'RT 03', 'RT 04'],
            'Kemiri|RW 02'     => ['RT 01', 'RT 02', 'RT 03', 'RT 04'],
            'Ngares|RW 03'     => ['RT 01', 'RT 02', 'RT 03'],
            'Donowarih|RW 03'  => ['RT 04'],
            'Ngares|RW 04'     => ['RT 01', 'RT 02', 'RT 03'],
            'Tempuran|RW 05'   => ['RT 01', 'RT 02', 'RT 03', 'RT 04'],
            'Tempuran|RW 06'   => ['RT 01', 'RT 02', 'RT 03'],
            'Bulakan|RW 07'    => ['RT 01', 'RT 02', 'RT 03', 'RT 04'],
            'Bulakan|RW 11'    => ['RT 01', 'RT 02'],
            'Tegalrejo|RW 08'  => ['RT 01'],
            'Tlogorejo|RW 08'  => ['RT 02', 'RT 03'],
            'Kebonwetan|RW 09' => ['RT 01'],
            'Kauman|RW 09'     => ['RT 02'],
        ];

        foreach ($mapping as $key => $rts) {
            [$hamletName, $rwName] = explode('|', $key);

            // cari RW berdasarkan dusun dan nama RW
            $rw = Rw::whereHas('hamlet', fn($q) => $q->where('name', $hamletName))
                    ->where('name', $rwName)
                    ->first();

            if ($rw) {
                foreach ($rts as $rtName) {
                    Rt::firstOrCreate([
                        'rw_id'     => $rw->id,
                        'hamlet_id' => $rw->hamlet_id, // ikut isi otomatis
                        'name'      => $rtName,
                    ]);
                }
            }
        }
    }
}
