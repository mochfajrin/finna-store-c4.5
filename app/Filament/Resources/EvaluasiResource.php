<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluasiResource\Pages;
use App\Filament\Resources\EvaluasiResource\RelationManagers;
use App\Models\Evaluasi;
use App\Models\Kriteria;
use App\Models\Pelamar;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EvaluasiResource extends Resource
{
    protected static ?string $model = Evaluasi::class;
    protected static ?string $modelLabel = 'Evaluasi';
    protected static ?string $pluralModelLabel = 'Evaluasi';

    protected static ?string $navigationLabel = 'Evaluasi';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("pelamar_id")->relationship('pelamar', 'nama')->searchable()->required()->label("Nama Pelamar")
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Set $set) {
                        $set('lowongan', Pelamar::where("id", $state)->first()->lowongan()->first()->judul);
                    }),
                TextInput::make("lowongan")->disabled()->default(function (callable $get) {
                    return Pelamar::where("id", $get("pelamar_id"))->first()?->lowongan()->first()->judul;
                }),
                Select::make("kriteria_id")->relationship('kriteria', 'judul')->searchable()->required()->label("Nama Kriteria")
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Set $set) {
                        $set('kriteria', Kriteria::where("id", $state)->first()->lowongan()->first()->judul);
                    }),
                TextInput::make("kriteria")->disabled()->default(function (callable $get) {
                    return Kriteria::where("id", $get("pelamar_id"))->first()?->lowongan()->first()->judul;
                }),
                TextInput::make("nilai")->numeric()->minValue(0)->maxValue(100)->default(0)
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
