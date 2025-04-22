<?php

namespace App\Filament\Resources\WawancaraResource\Pages;

use App\Filament\Resources\WawancaraResource;
use App\Http\Controllers\ModelController;
use App\Models\Penilaian;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditWawancara extends EditRecord
{
    protected static string $resource = WawancaraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    public function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model {
        Log::info("==============Update========");
        Log::info($data);
        return $record;
    }

}
