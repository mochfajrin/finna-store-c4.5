<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilSeleksiResource\Pages;
use App\Filament\Resources\HasilSeleksiResource\RelationManagers;
use App\Models\Pelamar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class HasilSeleksiResource extends Resource
{
    protected static ?string $pluralModelLabel = 'Hasil Seleksi';

    protected static ?string $navigationLabel = 'Hasil Seleksi';

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $evaluations = Pelamar::query()
            ->leftJoin('tes as t', 'pelamars.id', '=', 't.pelamar_id')
            ->leftJoin('evaluasis as e', 'pelamars.id', '=', 'e.pelamar_id')
            ->leftJoin('kriterias as k', 'e.kriteria_id', '=', 'k.id')
            ->leftJoin('wawancaras as w', 'pelamars.id', '=', 'w.pelamar_id')
            ->leftJoin('penilaians as n', 'pelamars.id', '=', 'n.pelamar_id')
            ->select([
                'pelamars.id as id',
                'pelamars.nama as nama',
                DB::raw("MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END) as riwayat"),
                DB::raw("MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END) as ktp"),
                DB::raw("MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END) as skck"),
                DB::raw("MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END) as ijazah"),
                DB::raw("MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END) as buta_warna"),
                DB::raw("MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END) as kemampuan"),
                'w.nilai as wawancara',
                'n.status as status',
                DB::raw("
                COALESCE(MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END), 0) +
                COALESCE(MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END), 0) +
                COALESCE(MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END), 0) +
                COALESCE(MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END), 0) +
                COALESCE(MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END), 0) +
                COALESCE(MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END), 0) +
                COALESCE(w.nilai, 0) +
                COALESCE(n.status, 0)
            AS total")
            ])
            ->groupBy('pelamars.id', 'pelamars.nama', 'w.nilai', 'n.status');

        return $table
            ->query($evaluations)
            ->columns([
                TextColumn::make('id')->label("Kode Pelamar")->searchable()->sortable(),
                TextColumn::make("nama")->searchable()->sortable(),
                TextColumn::make("riwayat"),
                TextColumn::make("ktp"),
                TextColumn::make("skck"),
                TextColumn::make("ijazah"),
                TextColumn::make("buta_warna"),
                TextColumn::make("kemampuan"),
                TextColumn::make("wawancara"),
                TextColumn::make("total")->sortable()->searchable(),
                TextColumn::make("status")->formatStateUsing(fn($state) => $state == 1 ? 'Diterima' : 'Ditolak')
                    ->color(fn($state) => $state == 1 ? 'success' : 'danger')->badge()->sortable()->searchable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasilSeleksis::route('/'),
        ];
    }
}
