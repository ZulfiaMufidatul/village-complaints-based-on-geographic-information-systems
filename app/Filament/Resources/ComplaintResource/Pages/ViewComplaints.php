<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;

class ViewComplaint extends ViewRecord
{
    protected static string $resource = ComplaintResource::class;

    public function getTitle(): string
    {
        return 'Detail Aduan';
    }

    public function getBreadcrumb(): string
    {
        return 'Detail';
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('complaints_code')
                                    ->label('Kode Aduan')
                                    ->icon('heroicon-o-hashtag')
                                    ->iconColor('primary')
                                    ->copyable()
                                    ->badge()
                                    ->color('primary')
                                    ->size('lg'),

                                TextEntry::make('request_status')
                                    ->label('Status Permintaan')
                                    ->badge()
                                    ->size('lg')
                                    ->icon(fn(string $state): string => match ($state) {
                                        'approved' => 'heroicon-o-check-circle',
                                        'rejected' => 'heroicon-o-x-circle',
                                        'pending' => 'heroicon-o-clock',
                                        default => 'heroicon-o-question-mark-circle',
                                    })
                                    ->color(fn(string $state): string => match ($state) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'pending' => 'warning',
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
                                    ->size('lg')
                                    ->icon(fn(string $state): string => match ($state) {
                                        'done' => 'heroicon-o-check-circle',
                                        'process' => 'heroicon-o-arrow-path',
                                        'cancel' => 'heroicon-o-x-circle',
                                        'pending' => 'heroicon-o-clock',
                                        default => 'heroicon-o-question-mark-circle',
                                    })
                                    ->color(fn(string $state): string => match ($state) {
                                        'done' => 'success',
                                        'process' => 'info',
                                        'cancel' => 'danger',
                                        'pending' => 'warning',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state): string => match ($state) {
                                        'done' => 'Selesai',
                                        'process' => 'Diproses',
                                        'cancel' => 'Dibatalkan',
                                        'pending' => 'Belum Diproses',
                                        default => ucfirst($state),
                                    }),
                            ])
                    ])
                    ->columnSpan('full'),

                Split::make([
                    Section::make('Dokumentasi')
                        ->icon('heroicon-o-camera')
                        ->iconColor('success')
                        ->schema([
                            ImageEntry::make('photo')
                                ->label('Foto Aduan')
                                ->disk('public')
                                ->visibility('public')
                                ->width('100%')
                                ->height(300)
                                // ->extraAttributes([
                                //     'class' => 'rounded-lg shadow-md border border-gray-200 object-contain w-full h-full max-h-[350px]'
                                // ])
                                ->placeholder('Tidak ada foto tersedia')
                                ->hidden(fn($record) => !$record->photo),
                        ])
                        ->extraAttributes([
                            'style' => 'height: 450px; display: flex; flex-direction: column;',
                            'class' => 'flex-1'
                        ])
                        ->hidden(fn($record) => !$record->photo),

                    Section::make('Peta Lokasi')
                        ->icon('heroicon-o-map-pin')
                        ->iconColor('danger')
                        ->schema([
                            ViewEntry::make('map')
                                ->label('')
                                ->view('components.partials.complaint-map')
                                ->viewData(fn($record) => [
                                    'latitude' => $record->latitude,
                                    'longitude' => $record->longitude,
                                ])
                                ->extraAttributes([
                                    'class' => 'h-[350px] rounded-lg overflow-hidden shadow-md border-2 border-gray-200 w-full'
                                ])
                        ])
                        ->extraAttributes([
                            'style' => 'height: 450px; display: flex; flex-direction: column;',
                            'class' => 'flex-1'
                        ])
                        ->hidden(fn($record) => !$record->latitude || !$record->longitude),
                ])
                    ->from('md')
                    ->columnSpan('full'),

                // Reporter Information
                Section::make('Informasi Pelapor')
                    ->icon('heroicon-o-identification')
                    ->iconColor('info')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nama Pelapor')
                                    ->icon('heroicon-o-user')
                                    ->iconColor('primary'),

                                TextEntry::make('phone')
                                    ->label('No Handphone')
                                    ->icon('heroicon-o-phone')
                                    ->iconColor('primary')
                                    ->copyable()
                                    ->url(fn($state) => $state ? "tel:{$state}" : null),

                                TextEntry::make('email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope')
                                    ->iconColor('primary')
                                    ->copyable()
                                    ->url(fn($state) => $state ? "mailto:{$state}" : null)
                                    ->columnSpan(2),
                            ])
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->columns(1),

                // Location Information
                Section::make('Informasi Lokasi')
                    ->icon('heroicon-o-map')
                    ->iconColor('danger')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('hamlet')
                                    ->label('Dusun')
                                    ->icon('heroicon-o-home')
                                    ->iconColor('danger'),

                                TextEntry::make('latitude')
                                    ->label('Latitude')
                                    ->icon('heroicon-o-globe-alt')
                                    ->iconColor('danger')
                                    ->copyable()
                                    ->numeric(6),

                                TextEntry::make('rw')
                                    ->label('RW')
                                    ->icon('heroicon-o-building-office')
                                    ->iconColor('danger'),

                                TextEntry::make('longitude')
                                    ->label('Longitude')
                                    ->icon('heroicon-o-globe-alt')
                                    ->iconColor('danger')
                                    ->copyable()
                                    ->numeric(6),

                                TextEntry::make('rt')
                                    ->label('RT')
                                    ->icon('heroicon-o-building-office-2')
                                    ->iconColor('danger'),
                            ])
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->columns(1),

                // Complaint Details
                Section::make('Detail Aduan')
                    ->icon('heroicon-o-megaphone')
                    ->iconColor('warning')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('infrastructure_category')
                                    ->label('Kategori Infrastruktur')
                                    ->icon('heroicon-o-wrench-screwdriver')
                                    ->iconColor('amber')
                                    ->badge()
                                    ->color('warning')
                                    ->size('lg'),

                                TextEntry::make('date_time')
                                    ->label('Waktu Aduan')
                                    ->icon('heroicon-o-calendar-days')
                                    ->iconColor('gray')
                                    ->dateTime('d M Y H:i')
                                    ->badge()
                                    ->color('warning'),
                            ]),

                        TextEntry::make('description')
                            ->label('Deskripsi Aduan')
                            ->icon('heroicon-o-clipboard-document')
                            ->iconColor('slate')
                            ->prose()
                            ->markdown()
                            ->extraAttributes([
                                'class' => 'bg-gray-50 p-4 rounded-lg border border-gray-200 text-gray-700 leading-relaxed'
                            ])
                            ->columnSpan('full'),
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->columns(2),

                // Admin Response
                Section::make('Respon Admin')
                    ->icon('heroicon-o-inbox')
                    ->iconColor('success')
                    ->schema([
                        TextEntry::make('response')
                            ->label('Komentar/Respon Admin')
                            ->icon('heroicon-o-chat-bubble-left')
                            ->iconColor('success')
                            ->prose()
                            ->markdown()
                            ->placeholder('Belum ada tanggapan dari admin')
                            ->extraAttributes([
                                'class' => 'bg-blue-50 p-4 rounded-lg border border-blue-200 text-blue-800 leading-relaxed'
                            ])
                    ])
                    ->collapsible()
                    ->persistCollapsed()
                    ->hidden(fn($record) => !$record->response),
            ]);
    }
}
