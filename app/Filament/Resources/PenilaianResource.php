<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianResource\Pages;
use App\Filament\Resources\PenilaianResource\RelationManagers;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\Penilaian;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
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
use Illuminate\Support\Facades\DB;

class PenilaianResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = Penilaian::class;
    protected static ?string $modelLabel = 'Penilaian';
    protected static ?string $pluralModelLabel = 'Penilaian';

    protected static ?string $navigationLabel = 'Penilaian';

    protected static ?int $navigationSort = 7;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pelamar_id')->searchable()->options(Pelamar::query()->join('lowongans', 'pelamars.lowongan_id', '=', 'lowongans.id')->select('pelamars.id', DB::raw("CONCAT(pelamars.id,' - ',pelamars.nama, ' - ', lowongans.judul) as pelamar"))->pluck('pelamar', 'pelamars.id'))->label("Pelamar"),
                Checkbox::make("status")->default(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->searchable()->sortable(),
                TextColumn::make("pelamar.id")->label("Kode Pelamar")->searchable()->sortable(),
                TextColumn::make("pelamar.nama")->label("Nama Pelamar")->searchable()->sortable(),
                TextColumn::make("pelamar.lowongan.judul")->label("Pekerjaan")->searchable()->sortable(),
                TextColumn::make("status")->searchable(),
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
            'index' => Pages\ListPenilaians::route('/'),
            'create' => Pages\CreatePenilaian::route('/create'),
            'edit' => Pages\EditPenilaian::route('/{record}/edit'),
        ];
    }
}
