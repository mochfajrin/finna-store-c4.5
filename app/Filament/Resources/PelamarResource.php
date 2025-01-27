<?php

namespace App\Filament\Resources;

use App\Enums\PelamarGender;
use App\Filament\Resources\PelamarResource\Pages;
use App\Filament\Resources\PelamarResource\RelationManagers;
use App\Models\Pelamar;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

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
                Section::make("Data diri")->schema([
                    TextInput::make('nama')->label("Nama"),
                    Select::make('jenis_kelamin')->label('Jenis Kelamin')->options(PelamarGender::class),
                    TextInput::make('no_telepon')->label("No Telepon"),
                    TextInput::make('email')->label('Email'),
                    TextInput::make('alamat')->label('Alamat'),
                    TextInput::make('tanggal_lahir')->label('Tanggal Lahir'),
                ])->columns(2),
                Section::make("Berkas")->schema([
                    FileUpload::make('url_foto')->directory('lamaran/foto')->hidden(true),
                    PdfViewerField::make("url_foto")->label("Foto"),
                    FileUpload::make('url_ijazah')->directory('lamaran/ijazah')->hidden(true),
                    PdfViewerField::make("url_ijazah")->label("Ijazah"),
                    FileUpload::make('url_skck')->directory('lamaran/skck')->hidden(true),
                    PdfViewerField::make("url_skck")->label("SKCK"),
                    FileUpload::make('url_ktp')->directory('lamaran/ktp')->hidden(true),
                    PdfViewerField::make("url_ktp")->label("ktp"),
                    FileUpload::make('url_riwayat')->directory('lamaran/riwayat')->hidden(true),
                    PdfViewerField::make("url_riwayat")->label("Riwayat"),
                ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->sortable()->searchable(),
                TextColumn::make('jenis_kelamin')->label("Jenis Kelamin"),
                TextColumn::make('no_telepon')->label("No Telepon"),
                TextColumn::make('email')->label("Email"),
                TextColumn::make('alamat')->label("Alamat"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPelamars::route('/'),
            'create' => Pages\CreatePelamar::route('/create'),
            'edit' => Pages\EditPelamar::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('{record}')
        ];
    }
}
