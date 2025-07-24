<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComplaints extends ListRecords
{
    protected static string $resource = ComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function exportPdf()
    {
        $dateRangeRaw = $this->tableFilters['created_at']['created_at'] ?? null;

        $start = null;
        $end = null;

        if ($dateRangeRaw) {
            [$start, $end] = explode(' - ', $dateRangeRaw);
            $start = Carbon::createFromFormat('d/m/Y', $start)->format('Y-m-d');
            $end = Carbon::createFromFormat('d/m/Y', $end)->format('Y-m-d');
        }

        return redirect(route('exportToPdf') . '?start=' . $start . '&end=' . $end);
    }
}
