<?php

namespace App\Filament\Resources\NIKResource\Pages;

use App\Filament\Resources\NIKResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditNIK extends EditRecord
{
    protected static string $resource = NIKResource::class;
    protected static ?string $title = 'Edit Data NIK';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Data NIK'),
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(NIKResource::getUrl('index'))
        ];
    }

    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
