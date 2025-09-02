<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeopleResource\Pages;
use App\Filament\Resources\PeopleResource\RelationManagers;
use App\Models\NIK;
use App\Models\User;
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
use Illuminate\Support\Facades\Hash;

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
                Select::make('nik_id')
                    ->label('NIK')
                    ->relationship('nik', 'value')
                    ->options(function () {
                        return NIK::whereDoesntHave('user')
                            ->pluck('value', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->validationMessages([
                        'required' => 'NIK wajib diisi.',
                    ])
                    ->afterStateHydrated(function (Select $component, $state, $record) {
                        if ($record && $record->nik) {
                            $component->state($record->nik->id);
                        }
                    }),
                TextInput::make('email')
                    ->label('Email')
                    ->placeholder('Masukkan Email')
                    ->required()
                    ->validationMessages([
                        'required' => 'Email wajib diisi.',
                    ]),
                TextInput::make('name')
                    ->label('Nama')
                    ->placeholder('Masukkan Nama')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama wajib diisi.',
                    ]),
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->placeholder('Masukkan Kata Sandi')
                    ->password()
                    ->required(fn($context) => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->validationMessages([
                        'required' => 'Kata sandi wajib diisi.',
                    ]),
                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Kata Sandi')
                    ->placeholder('Masukkan Konfirmasi Kata Sandi')
                    ->password()
                    ->dehydrated(false)
                    ->required(fn($context) => $context === 'create')
                    ->same('password')
                    ->validationMessages([
                        'same' => 'Konfirmasi kata sandi harus sama dengan kata sandi.',
                        'required' => 'Konfirmasi kata sandi wajib diisi.',
                    ]),
                // TextInput::make('password')
                //     ->label('Kata Sandi')
                //     ->placeholder('Masukkan Kata Sandi')
                //     ->password()
                //     ->required(fn ($context) => $context === 'create')
                //     ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                // TextInput::make('password_confirmation')
                //     ->label('Konfirmasi Kata Sandi')
                //     ->placeholder('Masukkan Konfirmasi Kata Sandi')
                //     ->password()
                //     ->dehydrated(false)
                //     ->required(fn ($context) => $context === 'create')
                //     ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik.value')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->searchable()
                    ->sortable(),
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

    // Akses: superadmin full, admin hanya view
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view-people');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create-people');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('edit-people');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete-people');
    }
}
