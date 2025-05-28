<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\UserResource;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('name')->label('Nama'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('roles.name')->label('Role')->badge()->color('primary'),
                        TextEntry::make('password')->label('Password')->getStateUsing(fn($record) => '********')
                    ])
                    ->columns(1)
                    ->columnSpanFull(),

            ]);
    }
}
