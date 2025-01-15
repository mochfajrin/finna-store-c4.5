<?php

namespace App\Filament\Resources\TesResource\Pages;

use App\Filament\Resources\TesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTes extends EditRecord
{
    protected static string $resource = TesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
