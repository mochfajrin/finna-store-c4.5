<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelamarResource\Pages;
use App\Filament\Resources\PelamarResource\RelationManagers;
use App\Models\Pelamar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PelamarResource extends Resource
{
    protected static ?string $model = Pelamar::class;
    protected static ?string $modelLabel = 'Data Pelamar';
    protected static ?string $pluralModelLabel = 'Data Pelamar';

    protected static ?string $navigationLabel = 'Data Pelamar';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
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
            'index' => Pages\ListPelamars::route('/'),
            'create' => Pages\CreatePelamar::route('/create'),
            'edit' => Pages\EditPelamar::route('/{record}/edit'),
        ];
    }
}
