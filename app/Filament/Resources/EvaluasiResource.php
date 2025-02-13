<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluasiResource\Pages;
use App\Filament\Resources\EvaluasiResource\RelationManagers;
use App\Models\Evaluasi;
use App\Models\Kriteria;
use App\Models\Lowongan;
use App\Models\Pelamar;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class EvaluasiResource extends Resource
{
    protected static ?string $model = Evaluasi::class;
    protected static ?string $modelLabel = 'Evaluasi';
    protected static ?string $pluralModelLabel = 'Evaluasi';

    protected static ?string $navigationLabel = 'Evaluasi';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lowongan_id')->searchable()->options(Lowongan::query()->select('id', DB::raw("CONCAT(id,'-',judul) as lowongan"))->pluck('lowongan', 'id'))->live()->label("Lowongan")->required(),
                Select::make('pelamar_id')->searchable()->options(Pelamar::query()->join('lowongans', 'pelamars.lowongan_id', '=', 'lowongans.id')->select('pelamars.id', DB::raw("CONCAT(pelamars.id,' - ',pelamars.nama, ' - ', lowongans.judul) as pelamar"))->pluck('pelamar', 'pelamars.id'))->label("Pelamar")->required(),
                Select::make("ijazah")->options([
                    'sd' => 'SD',
                    'smp' => 'SMP',
                    'sma' => 'SMA',
                    'perguruan_tinggi' => 'Perguruan Tinggi',
                ])->visible(function (Get $get) {
                    return Kriteria::where('lowongan_id', $get('lowongan_id'))->where('judul', 'ijazah')->exists();
                })->required(function (Get $get) {
                    return Kriteria::where('lowongan_id', $get('lowongan_id'))->where('judul', 'ijazah')->exists();
                }),
                TextInput::make("riwayat")->numeric()->minValue(0)->maxValue(100)->visible(function (Get $get) {
                    return Kriteria::where('lowongan_id', $get('lowongan_id'))->where('judul', 'riwayat')->exists();
                })->required(function (Get $get) {
                    return Kriteria::where('lowongan_id', $get('lowongan_id'))->where('judul', 'ijazah')->exists();
                }),
                Checkbox::make("skck")->visible(function (Get $get) {
                    return Kriteria::where('lowongan_id', $get('lowongan_id'))->where('judul', 'skck')->exists();
                })->default(false),
                Checkbox::make("ktp")->visible(function (Get $get) {
                    return Kriteria::where('lowongan_id', $get('lowongan_id'))->where('judul', 'ktp')->exists();
                })->default(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->searchable(),
                TextColumn::make("pelamar.nama")->searchable(),
                TextColumn::make('kriteria.judul')->searchable(),
                TextColumn::make('nilai')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListEvaluasis::route('/'),
            'create' => Pages\CreateEvaluasi::route('/create'),
            'edit' => Pages\EditEvaluasi::route('/{record}/edit'),
        ];
    }

}
