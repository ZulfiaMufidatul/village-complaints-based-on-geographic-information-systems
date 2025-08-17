<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(UserResource::getUrl('index'))
        ];
    }

    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
