<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeopleResource\Pages;
use App\Filament\Resources\PeopleResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class PeopleResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Masyarakat';
    protected static ?string $navigationGroup = 'App';

    protected static ?string $modelLabel = 'Masyarakat';
    protected static ?string $pluralModelLabel = 'Masyarakat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nik_value')
                ->label('NIK')
                ->placeholder('Masukkan NIK')
                ->dehydrated(false)
                ->afterStateHydrated(function (TextInput $component, $state, $record) {
                    if ($record && $record->nik) {
                        $component->state($record->nik->value);
                    }
                }),
                TextInput::make('email')
                    ->label('Email')
                    ->placeholder('Masukkan Email'),
                TextInput::make('name')
                    ->label('Nama')
                    ->placeholder('Masukkan Nama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik.value')
                    ->label('NIK'),
                TextColumn::make('name')
                    ->label('Nama'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('created_at')
                    ->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePeople::route('/create'),
            'edit' => Pages\EditPeople::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->whereHas('roles', function ($query) {
            $query->where('name', 'public');
        });
}

}
