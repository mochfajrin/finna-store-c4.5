<?php

namespace App\Filament\Resources;

use App\Enums\PelamarGender;
use App\Filament\Resources\PelamarResource\Pages;
use App\Filament\Resources\PelamarResource\RelationManagers;
use App\Models\Lowongan;
use App\Models\Pelamar;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PelamarResource extends Resource
{
    protected static ?string $model = Pelamar::class;
    protected static ?string $modelLabel = 'Data Pelamar';
    protected static ?string $pluralModelLabel = 'Data Pelamar';
    protected static ?string $navigationLabel = 'Data Pelamar';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                    FileUpload::make('url_foto')->directory('lamaran/foto')->visible(function (Get $get) {
                        $mimetype = Storage::mimeType('public' . Arr::first($get('url_foto')));
                        $parts = explode('/', $mimetype);
                        return $parts[0] === 'image';
                    }),
                    PdfViewerField::make("url_foto")->label("Foto")->visible(function (Get $get) {
                        $mimetype = Storage::mimeType('public' . Arr::first($get('url_foto')));
                        $parts = explode('/', $mimetype);
                        return $parts[0] !== 'image';
                    }),
                    FileUpload::make('url_ijazah')->directory('lamaran/ijazah')->hidden(true),
                    PdfViewerField::make("url_ijazah")->label("Ijazah")->visible(function (Get $get) {
                        $id = Pelamar::where('id', $get('id'))->first()->lowongan->id;
                        return Lowongan::where('id', $id)->first()->kriterias()->where('judul', 'ijazah')->exists();
                    }),
                    FileUpload::make('url_skck')->directory('lamaran/skck')->hidden(true),
                    PdfViewerField::make("url_skck")->label("SKCK")->visible(function (Get $get) {
                        $id = Pelamar::where('id', $get('id'))->first()->lowongan->id;
                        return Lowongan::where('id', $id)->first()->kriterias()->where('judul', 'skck')->exists();
                    }),
                    FileUpload::make('url_ktp')->directory('lamaran/ktp')->hidden(true),
                    PdfViewerField::make("url_ktp")->label("KTP")->visible(function (Get $get) {
                        $id = Pelamar::where('id', $get('id'))->first()->lowongan->id;
                        return Lowongan::where('id', $id)->first()->kriterias()->where('judul', 'ktp')->exists();
                    }),
                    FileUpload::make('url_riwayat')->directory('lamaran/riwayat')->hidden(true),
                    PdfViewerField::make("url_riwayat")->label("Riwayat (CV)")->visible(function (Get $get) {
                        $id = Pelamar::where('id', $get('id'))->first()->lowongan->id;
                        return Lowongan::where('id', $id)->first()->kriterias()->where('judul', 'riwayat')->exists();
                    }),
                ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Kode Pelamar')->sortable()->searchable(),
                TextColumn::make('nama')->label('Nama')->sortable()->searchable(),
                TextColumn::make('lowongan.judul')->label('Lowongan')->sortable()->searchable(),
                TextColumn::make('jenis_kelamin')->label("Jenis Kelamin")->formatStateUsing(fn($state) => PelamarGender::tryFrom($state)->getLabel())->searchable(),
                TextColumn::make('no_telepon')->label("No Telepon")->searchable(),
                TextColumn::make('email')->label("Email")->searchable()->sortable(),
                TextColumn::make('alamat')->label("Alamat")->searchable()->sortable(),
            ])
            ->defaultSort('id', 'desc')
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
