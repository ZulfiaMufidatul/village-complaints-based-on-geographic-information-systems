<?php

namespace App\Filament\Resources\NIKResource\Pages;

use App\Filament\Resources\NIKResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNIK extends CreateRecord
{
    protected static string $resource = NIKResource::class;
    protected static ?string $title = 'Tambah Data NIK';
}
