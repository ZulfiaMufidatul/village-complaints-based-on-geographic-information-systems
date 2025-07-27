<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ComplaintExporter;
use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Aduan';
    protected static ?string $navigationGroup = 'App';
    protected static ?string $pluralLabel = 'Data Aduan';

    // Batasi akses resource sesuai permissionnya
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view-complaints');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create-complaints');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('edit-complaints');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete-complaints');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('request_status')
                    ->label('Status Permintaan')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(
                        fn($state, callable $set) => $state === 'rejected'
                            ? $set('status_complaint', 'cancel')
                            : null
                    ),

                Select::make('status_complaint')
                    ->label('Status Aduan')
                    ->options(function (callable $get) {
                        $requestStatus = $get('request_status');

                        if ($requestStatus === 'approved') {
                            return [
                                'pending' => 'Belum Diproses',
                                'process' => 'Diproses',
                                'done' => 'Selesai',
                            ];
                        }

                        if ($requestStatus === 'rejected') {
                            return [
                                'cancel' => 'Dibatalkan',
                            ];
                        }

                        return [
                            'pending' => 'Belum Diproses',
                            'process' => 'Diproses',
                            'done' => 'Selesai',
                            'cancel' => 'Dibatalkan',
                        ];
                    })
                    ->disabled(fn(callable $get) => $get('request_status') === 'rejected')
                    ->required()
                    ->reactive(),

                Textarea::make('response')
                    ->label('Tanggapan')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(isFromZero: false),

                TextColumn::make('hamlet')
                    ->label('Dusun'),

                TextColumn::make('infrastructure_category')
                    ->label('Kategori Infrastruktur'),

                TextColumn::make('name')
                    ->label('Pelapor'),

                TextColumn::make('date_time')
                    ->label('Waktu Pengaduan')
                    ->dateTime('d M Y H:i'),

                TextColumn::make('request_status')
                    ->label('Status Permintaan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'pending' => 'Menunggu',
                        default => ucfirst($state),
                    }),

                TextColumn::make('status_complaint')
                    ->label('Status Aduan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'done' => 'success',
                        'process' => 'info',
                        'cancel' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'done' => 'Selesai',
                        'process' => 'Diproses',
                        'cancel' => 'Dibatalkan',
                        'pending' => 'Belum Diproses',
                        default => ucfirst($state),
                    }),
            ])
            ->filters([
                DateRangeFilter::make('created_at')
                    ->label('Tanggal')
                    ->placeholder("Pilih Rentang Tanggal"),
                SelectFilter::make('status_complaint')
                    ->label('Status Aduan')
                    ->options([
                        'pending' => 'Belum Diproses',
                        'process' => 'Diproses',
                        'done' => 'Selesai',
                        'cancel' => 'Dibatalkan',
                    ]),

                SelectFilter::make('hamlet')
                    ->label('Dusun')
                    ->options(function () {
                        return Complaint::query()
                            ->select('hamlet')
                            ->distinct()
                            ->orderBy('hamlet')
                            ->pluck('hamlet', 'hamlet')
                            ->toArray();
                    }),
                SelectFilter::make('infrastructure_category')
                    ->label('Kategori Infrastruktur')
                    ->options(function () {
                        return Complaint::query()
                            ->select('infrastructure_category')
                            ->distinct()
                            ->orderBy('infrastructure_category')
                            ->pluck('infrastructure_category', 'infrastructure_category')
                            ->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),
                Tables\Actions\EditAction::make()
                    ->label('Proses'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => Auth::user()->can('delete-complaints'))
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(ComplaintExporter::class)
                        ->label('Ekspor Data Yang Dipilih'),
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => Auth::user()->can('delete-complaints'))
                        ->label('Hapus Yang Dipilih'),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(ComplaintExporter::class)
                    ->label('Ekspor Data'),
                Action::make("exportPdf")
                    ->label("Ekspor PDF")
                    ->icon('heroicon-o-printer')
                    ->action('exportPdf')
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
            'index' => Pages\ListComplaints::route('/'),
            'view' => Pages\ViewComplaint::route('/{record}'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
