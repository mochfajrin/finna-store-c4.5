<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WawancaraResource\Pages;
use App\Filament\Resources\WawancaraResource\RelationManagers;
use App\Models\Wawancara;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                TextInput::make("nilai")->numeric()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->searchable()->sortable(),
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
