<?php

namespace App\Filament\Resources\WawancaraResource\Pages;

use App\Filament\Resources\WawancaraResource;
use App\Http\Controllers\ModelController;
use App\Models\Penilaian;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWawancara extends EditRecord
{
    protected static string $resource = WawancaraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
