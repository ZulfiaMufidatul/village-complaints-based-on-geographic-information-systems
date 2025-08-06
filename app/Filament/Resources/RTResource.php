<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RTResource\Pages;
use App\Filament\Resources\RTResource\RelationManagers;
use App\Models\RT;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RTResource extends Resource
{
    protected static ?string $model = RT::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Sistem - Geografis';
    protected static ?string $navigationLabel = 'RT';
    protected static ?string $pluralLabel = 'Data RT';

    // hak akses
    public static function canViewAny(): bool
    {
        return Auth::user()->can('view-rt');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('create-rt');
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->can('edit-rt');
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->can('delete-rt');
    }

    //  form
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('hamlet_id')
                    ->label('Dusun')
                    ->relationship('hamlet', 'name')
                    ->reactive() // saat Dusun diganti langsung trigger update pilihan RW.
                    ->afterStateUpdated(fn(callable $set) => $set('rw_id', null))
                    ->required(),
                Select::make('rw_id')
                    ->label('RW')
                    ->options(function (callable $get) {
                        $hamletId = $get('hamlet_id');
                        if (!$hamletId) {
                            return [];
                        }
                        return RW::where('hamlet_id', $hamletId)->pluck('name', 'id');
                    })
                    ->required(),
                TextInput::make('name')
                    ->label('RT')
                    ->placeholder('Masukkan RT')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hamlet.name')->label('Dusun')->sortable(),
                TextColumn::make('rw.name')->label('RW'),
                TextColumn::make('name')->label('RT')->searchable(),
                TextColumn::make('created_at')->dateTime()->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete-rt')),
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
            'index' => Pages\ListRTS::route('/'),
            'create' => Pages\CreateRT::route('/create'),
            'edit' => Pages\EditRT::route('/{record}/edit'),
        ];
    }
}
