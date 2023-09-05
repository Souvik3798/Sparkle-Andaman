<?php

namespace App\Filament\Resources\CustomPackageResource\Pages;

use App\Filament\Resources\CustomPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomPackage extends CreateRecord
{
    protected static string $resource = CustomPackageResource::class;

    protected function getRedirectUrl() : string {
        return $this->getResource()::getUrl('index');
    }
}
