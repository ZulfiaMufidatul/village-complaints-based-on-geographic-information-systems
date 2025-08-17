<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(UserResource::getUrl('index'))
        ];
    }

    // redirect index
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
