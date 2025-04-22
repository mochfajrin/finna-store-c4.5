<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WawancaraResource\Pages;
use App\Filament\Resources\WawancaraResource\RelationManagers;
use App\Models\Pertanyaan;
use App\Models\Wawancara;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WawancaraResource extends Resource
{
    protected static ?string $model = Wawancara::class;
    protected static ?string $modelLabel = 'Wawancara';
    protected static ?string $pluralModelLabel = 'Wawancara';

    protected static ?string $navigationLabel = 'Wawancara';

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Radio::make('Penampilan')->options([
                    'sangat_baik' => 'Sangat Baik',
                    'baik' => 'Baik',
                    'kurang' => 'Kurang'
                ])->inline()->required()->default(function (Get $get) {
                    return $get('id');
                }),
                Radio::make('Kemampuan')->options([
                    'sangat_baik' => 'Sangat Baik',
                    'baik' => 'Baik',
                    'kurang' => 'Kurang'
                ])->inline()->required(),
                Radio::make('Sopan Santun (Etika)')->options([
                    'sangat_baik' => 'Sangat Baik',
                    'baik' => 'Baik',
                    'kurang' => 'Kurang'
                ])->inline()->required(),
                Radio::make('Pemecahan Masalah')->options([
                    'sangat_baik' => 'Sangat Baik',
                    'baik' => 'Baik',
                    'kurang' => 'Kurang'
                ])->inline()->required(),
                Radio::make('Pengalaman Organisasi')->options([
                    'sangat_baik' => 'Sangat Baik',
                    'baik' => 'Baik',
                    'kurang' => 'Kurang'
                ])->inline()->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->searchable()->sortable(),
                TextColumn::make("pelamar.id")->label("Kode Pelamar")->searchable()->sortable(),
                TextColumn::make("user.name")->label("Nama HRD")->searchable()->sortable(),
                TextColumn::make("pelamar.nama")->label("Nama Pelamar")->searchable()->sortable(),
                TextColumn::make("pelamar.lowongan.judul")->label("Pekerjaan")->searchable()->sortable(),
                TextColumn::make("nilai")->searchable()->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->using(function (Model $record, array $data): Model {
                    $wawancaraId = $record->id;
                    $pelamarId = $record->pelamar_id;
                    $totalNilai = 0;
                    foreach ($data as $key => $value) {
                        $nilai = 0;

                        if ($value == 'sangat_baik') {
                            $nilai = 20;
                        } else if ($value == 'baik') {
                            $nilai = 10;
                        } else if ($value == 'kurang') {
                            $nilai = 0;
                        }

                        $pertanyaan = Pertanyaan::where('pelamar_id', $pelamarId)
                            ->where('wawancara_id', $wawancaraId)
                            ->where('pertanyaan', $key);

                        if (!$pertanyaan->exists()) {
                            $pertanyaan->create([
                                'pelamar_id' => $pelamarId,
                                'wawancara_id' => $wawancaraId,
                                'pertanyaan' => $key,
                                'nilai' => $nilai
                            ]);
                        } else {
                            $pertanyaan = $pertanyaan->first();
                            $pertanyaan->nilai = $nilai;
                            $pertanyaan->save();
                        }

                        $totalNilai += $nilai;
                    }

                    $record->nilai = $totalNilai;
                    $record->save();
                    return $record;
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
    public static function canCreate(): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWawancaras::route('/'),
            'create' => Pages\CreateWawancara::route('/create'),
        ];
    }
}
