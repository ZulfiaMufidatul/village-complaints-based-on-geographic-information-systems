<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use Filament\Widgets\ChartWidget;

class CategoryComplaintChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Aduan per Kategori Infrastruktur';

    protected function getData(): array
    {
        $data = Complaint::select('infrastructure_category')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('infrastructure_category')
            ->pluck('total', 'infrastructure_category');

        $data = Complaint::select('hamlet')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('hamlet')
            ->pluck('total', 'hamlet');

        $colors = [
            '#eaaeeb', // ungu muda
            '#a5e0f2', // biru muda
            '#9ae3b4', // hijau muda
            '#ffbfd8', // pink muda
        ];

        $backgroundColors = [];
        $colorCount = count($colors);
        foreach (range(0, $data->count() - 1) as $i) {
            $backgroundColors[] = $colors[$i % $colorCount];
        }
        return [
            'datasets' => [
                [
                    'label' => 'Kategori Infrastruktur',
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
