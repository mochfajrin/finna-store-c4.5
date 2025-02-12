<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KriteriaResource\Pages;
use App\Filament\Resources\KriteriaResource\RelationManagers;
use App\Models\Kriteria;
use App\Models\Lowongan;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class KriteriaResource extends Resource
{
    protected static ?string $model = Kriteria::class;
    protected static ?string $modelLabel = 'Atur Kriteria';
    protected static ?string $pluralModelLabel = 'Atur Kriteria';
    protected static ?string $navigationLabel = 'Atur Kriteria';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('judul')->required()->options([
                    'ijazah' => "Ijazah",
                    'skck' => "SKCK",
                    'foto' => "Foto",
                    'ktp' => "KTP",
                    'riwayat' => "Riwayat (CV)",
                ])->rules([
                            function ($get) {
                                return Rule::unique('kriterias', 'judul')->where(function ($query) use ($get) {
                                    return $query->where('lowongan_id', $get('lowongan_id'));
                                });
                            },
                        ])
                    ->validationMessages([
                        'unique' => 'Kriteria dengan judul ini sudah ada untuk lowongan yang dipilih.',
                    ]),
                Select::make("lowongan_id")->relationship("lowongan", "judul")
                    ->searchable()
                    ->options(Lowongan::pluck('judul', 'id'))
                    ->required()
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")->searchable(),
                TextColumn::make("judul")->searchable(),
                TextColumn::make("lowongan.judul")->searchable(),
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKriterias::route('/'),
            'create' => Pages\CreateKriteria::route('/create'),
            'edit' => Pages\EditKriteria::route('/{record}/edit'),
        ];
    }
}
