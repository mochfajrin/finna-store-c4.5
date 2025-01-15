<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WawancaraResource\Pages;
use App\Filament\Resources\WawancaraResource\RelationManagers;
use App\Models\Wawancara;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WawancaraResource extends Resource
{
    protected static ?string $model = Wawancara::class;
    protected static ?string $modelLabel = 'Interview';
    protected static ?string $pluralModelLabel = 'Interview';

    protected static ?string $navigationLabel = 'Interview';

    protected static ?int $navigationSort = 4;
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
            'index' => Pages\ListWawancaras::route('/'),
            'create' => Pages\CreateWawancara::route('/create'),
            'edit' => Pages\EditWawancara::route('/{record}/edit'),
        ];
    }
}
