<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sistem';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Permission')
                    ->required()
                    ->maxLength(255),

                TextInput::make('guard_name')
                    ->label('Guard')
                    ->default('web')
                    ->disabled(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->state(function ($record, $livewire, $rowLoop) {
                        return $rowLoop->iteration;
                    }),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('guard_name')
                    ->label('Guard'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            // 'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    // Batasi akses resource sesuai permissionnya
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view-permissions');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create-permissions');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('edit-permissions');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete-permissions');
    }
}
