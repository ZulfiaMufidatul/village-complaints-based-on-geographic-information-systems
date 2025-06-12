<?php

namespace App\Filament\Exports;

use App\Models\Complaint;
use App\Notifications\ExportCompletedNotification;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ComplaintExporter extends Exporter
{
    protected static ?string $model = Complaint::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('hamlet'),
            ExportColumn::make('rw'),
            ExportColumn::make('rt'),
            ExportColumn::make('infrastructure_category'),
            ExportColumn::make('complaints_code'),
            ExportColumn::make('name'),
            ExportColumn::make('phone'),
            ExportColumn::make('email'),
            ExportColumn::make('description'),
            ExportColumn::make('photo'),
            ExportColumn::make('longitude'),
            ExportColumn::make('latitude'),
            ExportColumn::make('date_time'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your complaint export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function handleCompleted(Export $export): void
{
    parent::handleCompleted($export); // tetap jalankan notifikasi bawaan Filament

    // Kirim notifikasi ke user yang menjalankan export
    $export->user->notify(new ExportCompletedNotification($export));
}
}
