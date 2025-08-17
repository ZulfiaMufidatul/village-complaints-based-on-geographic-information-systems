<?php

namespace App\Filament\Resources\NIKResource\Pages;

use App\Filament\Resources\NIKResource;
use App\Models\NIK;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;
use Filament\Notifications\Notification;

class ListNIKS extends ListRecords
{
    protected static string $resource = NIKResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Import')
                ->color('success')
                ->form([
                    FileUpload::make('csv_file')
                        ->label('Upload File CSV')
                        ->acceptedFileTypes(['text/csv', 'text/plain'])
                        ->required()
                        ->directory('imports'),
                ])
                ->action(function (array $data) {
                    $filePath = Storage::path($data['csv_file']);
                    if (! file_exists($filePath)) {
                        throw new Exception("File tidak ditemukan.");
                    }

                    $niks = array_map('str_getcsv', file($filePath));
                    array_shift($niks);

                    try {
                        foreach ($niks as $record) {
                            NIK::updateOrCreate(
                                ['value' => $record[0]],
                                [
                                    'value' => $record[0],
                                ]
                            );
                        }
                        
                        Notification::make()
                            ->title('Import berhasil!')
                            ->success()
                            ->send();
                    } catch (Exception $e) {
                        Notification::make()
                            ->title('Import gagal!')
                            ->body($e->getMessage() ?? 'Terjadi kesalahan saat import data.')
                            ->danger()
                            ->send();
                    }

                }),
            Actions\CreateAction::make()
                ->label('Tambah Data NIK'),
        ];
    }
}
