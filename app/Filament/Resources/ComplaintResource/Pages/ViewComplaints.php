<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class ViewComplaint extends ViewRecord
{
    protected static string $resource = ComplaintResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ImageEntry::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->visibility('public')
                    ->width(300)
                    ->height(200)
                    ->hidden(fn($record) => !$record->photo),

                TextEntry::make('name')->label('Nama Pelapor'),
                TextEntry::make('phone')->label('No HP'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('infrastructure_category')->label('Kategori Infrastruktur'),
                TextEntry::make('hamlet')->label('Dusun'),
                TextEntry::make('rw')->label('RW'),
                TextEntry::make('rt')->label('RT'),
                TextEntry::make('status_complaint')
                    ->label('Status Aduan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'done' => 'success',
                        'process' => 'info',
                        'cancel' => 'danger',
                        default => 'warning',
                    }),
                TextEntry::make('request_status')
                    ->label('Status Permintaan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextEntry::make('description')->label('Deskripsi'),
                TextEntry::make('date_time')->label('Waktu Aduan')->dateTime('d M Y H:i'),
            ]);
    }
}
