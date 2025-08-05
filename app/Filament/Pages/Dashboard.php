<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CategoryComplaintChart;
use App\Filament\Widgets\ComplaintMap;
use App\Filament\Widgets\HamletComplaintChart;
use App\Filament\Widgets\StatsOverview;
use App\Models\Complaint;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
}

