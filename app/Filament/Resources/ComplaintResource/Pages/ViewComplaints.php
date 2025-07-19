<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
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

                ViewEntry::make('map')
                    ->label('Lokasi Aduan')
                    ->view('components.partials.complaint-map')
                    ->viewData(fn($record) => [
                        'latitude' => $record->latitude,
                        'longitude' => $record->longitude,
                    ])
                    ->hidden(fn($record) => !$record->latitude || !$record->longitude),

                TextEntry::make('complaints_code')->label('Kode Aduan')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('name')->label('Nama Pelapor')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('phone')->label('No HP')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('email')->label('Email')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('infrastructure_category')->label('Kategori Infrastruktur')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('hamlet')->label('Dusun')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('rw')->label('RW')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('rt')->label('RT')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('description')->label('Deskripsi')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('date_time')->label('Waktu Aduan')->dateTime('d M Y H:i')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('longitude')->label('longitude')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('latitude')->label('latitude')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
                TextEntry::make('request_status')
                    ->label('Status Permintaan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                        default => ucfirst($state),
                    }),
                TextEntry::make('status_complaint')
                    ->label('Status Aduan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'done' => 'success',
                        'process' => 'info',
                        'cancel' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'done' => 'Selesai',
                        'process' => 'Diproses',
                        'cancel' => 'Dibatalkan',
                        'pending' => 'Belum Diproses',
                        default => ucfirst($state),
                    }),
                TextEntry::make('response')->label('Komentar Admin')
                    ->extraAttributes(['class' => 'bg-gray-200 px-3 py-1 rounded-md']),
            ]);
    }
}
