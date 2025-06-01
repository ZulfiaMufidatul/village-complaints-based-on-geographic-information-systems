<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RWResource\Pages;
use App\Filament\Resources\RWResource\RelationManagers;
use App\Models\RW;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RWResource extends Resource
{
    protected static ?string $model = RW::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?string $navigationLabel = 'RW';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('view-rw');
    }
    public static function canCreate(): bool
    {
        return Auth::user()->can('create-rw');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->can('edit-rw');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->can('delete-rw');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('hamlet_id')
                    ->relationship('hamlet', 'name')
                    ->required()
                    ->label('Dusun'),
                TextInput::make('name')
                    ->required()
                    ->label('Nama RW'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hamlet.name')->label('Dusun')->sortable(),
                TextColumn::make('name')->label('Nama RW')->searchable(),
                TextColumn::make('created_at')->dateTime()->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn() => Auth::user()->can('edit-rw')),
                Tables\Actions\DeleteAction::make()->visible(fn() => Auth::user()->can('delete-rw')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete-rw')),
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
            'index' => Pages\ListRWS::route('/'),
            'create' => Pages\CreateRW::route('/create'),
            'edit' => Pages\EditRW::route('/{record}/edit'),
        ];
    }
}
