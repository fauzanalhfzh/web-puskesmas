<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\Pages;
use App\Filament\Resources\PendaftaranResource\RelationManagers;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'Pendaftaran';

    protected static ?string $navigationGroup = 'Kelola Data';

    protected static ?string $label = "Data Pendaftaran";

    protected static ?string $slug = "kelola-data/pendaftaran";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pasien_id')
                    ->label('Nama Pasien')
                    ->columnSpan('full')
                    ->required()
                    ->options(Pasien::all()->pluck('nama_lengkap', 'id')),
                Select::make('poli_id')
                    ->label('Nama Poli')
                    ->required()
                    ->options(Poli::all()->pluck('nama_poli', 'id')),
                Select::make('jalur')
                    ->options([
                        'Umum' => 'Umum',
                        'BPJS' => 'BPJS',
                    ])
                    ->required(),
                DatePicker::make('tanggal_kunjungan')
                    ->required(),
                Select::make('status')
                    ->required()
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_antrian')
                    ->label('Nomor Antrian')
                    ->searchable()
                    ->sortable()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pasien.nama_lengkap')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('poli.nama_poli')
                    ->label('Nama Poli')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_kunjungan')
                    ->label('Tanggal Kunjungan')
                    ->searchable()
                    ->date()
                    ->sortable(),
                TextColumn::make('jalur')
                    ->label('Jalur')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Tiket dibuat')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                // Filter untuk menampilkan data pendaftaran hari ini
                Filter::make('today')
                    ->label('Pendaftaran Hari Ini')
                    ->query(fn(Builder $query) => $query->whereDate('tanggal_kunjungan', Carbon::today())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'view' => Pages\ViewPendaftaran::route('/{record}'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
