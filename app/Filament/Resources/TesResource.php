<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TesResource\Pages;
use App\Filament\Resources\TesResource\RelationManagers;
use App\Models\Tes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TesResource extends Resource
{
    protected static ?string $model = Tes::class;
    protected static ?string $modelLabel = 'Tes';
    protected static ?string $pluralModelLabel = 'Tes';

    protected static ?string $navigationLabel = 'Tes';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->searchable()->sortable(),
                TextColumn::make("pelamar.nama")->searchable()->sortable(),
                TextColumn::make("pelamar.lowongan.judul")->searchable()->sortable(),
                TextColumn::make("jenis")->searchable()->sortable(),
                TextColumn::make("nilai")->searchable()->sortable(),
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
            'index' => Pages\ListTes::route('/'),
            'create' => Pages\CreateTes::route('/create'),
            'edit' => Pages\EditTes::route('/{record}/edit'),
        ];
    }
}
