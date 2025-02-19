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

    protected function afterSave(): void
    {
        parent::afterSave();

        if ($this->record->nilai != 0) {
            $penilaian = Penilaian::create([
                'pelamar_id' => $this->record->pelamar_id,
            ]);


            $modelController = new ModelController();

            $predictedStatus = $modelController->calculateC45($penilaian);

            $penilaian->update([
                'status' => $predictedStatus,
            ]);
        }
    }
}
