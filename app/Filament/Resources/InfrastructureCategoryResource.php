<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfrastructureCategoryResource\Pages;
use App\Filament\Resources\InfrastructureCategoryResource\RelationManagers;
use App\Models\InfrastructureCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InfrastructureCategoryResource extends Resource
{
    protected static ?string $model = InfrastructureCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Kategori Infrastruktur';
    protected static ?string $navigationGroup = 'App';
    protected static ?string $pluralLabel = 'Data Kategori Infrastruktur';


    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view-category');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create-category');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit-category');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete-category');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama kategori wajib diisi.',
                    ]),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->state(fn($record, $livewire, $rowLoop) => $rowLoop->iteration),

                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
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
            'index' => Pages\ListInfrastructureCategories::route('/'),
            'create' => Pages\CreateInfrastructureCategory::route('/create'),
            'edit' => Pages\EditInfrastructureCategory::route('/{record}/edit'),
        ];
    }
}
