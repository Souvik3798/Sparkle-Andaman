<?php

namespace App\Filament\Resources\GeneralPackageResource\Pages;

use App\Filament\Resources\GeneralPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeneralPackage extends CreateRecord
{
    protected static string $resource = GeneralPackageResource::class;

    protected function getRedirectUrl() : string {
        return $this->getResource()::getUrl('index');
    }
}
