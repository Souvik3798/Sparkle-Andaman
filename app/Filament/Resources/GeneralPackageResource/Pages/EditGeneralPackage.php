<?php

namespace App\Filament\Resources\GeneralPackageResource\Pages;

use App\Filament\Resources\GeneralPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeneralPackage extends EditRecord
{
    protected static string $resource = GeneralPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
