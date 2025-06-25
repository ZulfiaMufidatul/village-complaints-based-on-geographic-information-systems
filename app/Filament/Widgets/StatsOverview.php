<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        
        return [
            Stat::make('Total Aduan', Complaint::count()),
            Stat::make('Menunggu', Complaint::where('status_complaint', 'pending')->count()),
            Stat::make('Diproses',  Complaint::where('status_complaint', 'process')->count()),
            Stat::make('Selesai',  Complaint::where('status_complaint', 'done')->count()),
        ];
    }

}
