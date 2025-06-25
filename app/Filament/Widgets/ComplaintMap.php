<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use Filament\Widgets\Widget;

class ComplaintMap extends Widget
{
    protected static string $view = 'filament.widgets.complaint-map';
    protected int | string | array $columnSpan = 'full';

    public $complaints = [];

    public function mount(): void
    {
         $this->complaints = Complaint::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($complaint) {
                return [
                    'name' => $complaint->name,
                    'category' => $complaint->infrastructure_category, // ambil string langsung
                    'latitude' => (float) $complaint->latitude,
                    'longitude' => (float) $complaint->longitude,
                ];
            })
            ->toArray();
    }
   
}
