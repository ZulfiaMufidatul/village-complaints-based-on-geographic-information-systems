<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NIKResource\Pages;
use App\Filament\Resources\NIKResource\RelationManagers;
use App\Models\NIK;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NIKResource extends Resource
{
    protected static ?string $model = NIK::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'NIK';
    protected static ?string $navigationGroup = 'App';
    protected static ?string $pluralLabel = 'Data NIK';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('value')
                    ->label('NIK')
                    ->placeholder('Masukkan NIK')
                    ->required()
                    ->validationMessages([
                        'required' => 'NIK wajib diisi.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('value')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function ($record) {
                        return \App\Models\User::where('nik_id', $record->id)->exists()
                            ? 'Aktif'
                            : 'Tidak Aktif';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Tidak Aktif' => 'warning',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'aktif' => 'Aktif',
                    'tidak_aktif' => 'Tidak Aktif',
                ])
                ->query(function ($query, array $data) {
                    if (($data['value'] ?? null) === 'aktif') {
                        $query->whereHas('user');
                    } elseif (($data['value'] ?? null) === 'tidak_aktif') {
                        $query->whereDoesntHave('user');
                    }
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->user) {
                            $record->user->nik_id = null;
                            $record->user->save();
                        }
                    }),
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
            'index' => Pages\ListNIKS::route('/'),
            'create' => Pages\CreateNIK::route('/create'),
            'edit' => Pages\EditNIK::route('/{record}/edit'),
        ];
    }
}
