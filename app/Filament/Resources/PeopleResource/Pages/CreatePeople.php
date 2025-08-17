<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePeople extends CreateRecord
{
    protected static string $resource = PeopleResource::class;
    protected static ?string $title = 'Tambah Data Masyarakat';

    public function afterCreate(): void
    {
        $this->record->email_verified_at = now();
        $this->record->save();
        $this->record->assignRole('public');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(PeopleResource::getUrl('index'))
        ];
    }
}
