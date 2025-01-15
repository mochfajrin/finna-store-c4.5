<?php

namespace App\Filament\Resources\PelamarResource\Pages;

use App\Filament\Resources\PelamarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPelamar extends EditRecord
{
    protected static string $resource = PelamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
