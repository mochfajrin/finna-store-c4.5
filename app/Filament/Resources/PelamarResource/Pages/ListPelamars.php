<?php

namespace App\Filament\Resources\PelamarResource\Pages;

use App\Filament\Resources\PelamarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPelamars extends ListRecords
{
    protected static string $resource = PelamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
