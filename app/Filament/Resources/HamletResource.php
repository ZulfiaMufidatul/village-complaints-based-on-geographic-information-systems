<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HamletResource\Pages;
use App\Filament\Resources\HamletResource\RelationManagers;
use App\Models\Hamlet;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HamletResource extends Resource
{
    protected static ?string $model = Hamlet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nama Dusun')
                ->required()
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Nama Dusun')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->can('delete-hamlets')),
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
            'index' => Pages\ListHamlets::route('/'),
            'create' => Pages\CreateHamlet::route('/create'),
            'edit' => Pages\EditHamlet::route('/{record}/edit'),
        ];
    }
    
    // Akses: superadmin full, admin hanya view
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view-hamlets');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create-hamlets');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit-hamlets');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete-hamlets');
    }
}
