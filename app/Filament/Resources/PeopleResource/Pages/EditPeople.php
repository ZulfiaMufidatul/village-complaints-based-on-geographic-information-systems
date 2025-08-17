<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditPeople extends EditRecord
{
    protected static string $resource = PeopleResource::class;
    protected static ?string $title = 'Ubah Data Masyarakat';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(PeopleResource::getUrl('index'))
        ];
    }
}
