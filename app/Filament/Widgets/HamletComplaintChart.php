<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use Filament\Widgets\ChartWidget;

class HamletComplaintChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Aduan per Dusun';

    protected function getData(): array
    {
        $data = Complaint::select('hamlet')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('hamlet')
            ->pluck('total', 'hamlet');

        $colors = [
            '#f87171', // merah
            '#34d399', // hijau
            '#facc15', // kuning
            '#60a5fa', // biru
            '#f472b6', // pink
            '#a78bfa', // ungu
            '#fb923c', // oranye
            '#444a54', // abu-abu
        ];

        $backgroundColors = [];
        $colorCount = count($colors);
        foreach (range(0, $data->count() - 1) as $i) {
            $backgroundColors[] = $colors[$i % $colorCount];
        }
        return [
            'datasets' => [
                [
                    'label' => 'Dusun',
                    'data' => $data->values(),
                    'backgroundColor' => $backgroundColors,
                    
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
