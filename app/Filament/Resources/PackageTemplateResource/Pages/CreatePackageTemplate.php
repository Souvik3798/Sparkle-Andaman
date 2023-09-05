<?php

namespace App\Filament\Resources\PackageTemplateResource\Pages;

use App\Filament\Resources\PackageTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePackageTemplate extends CreateRecord
{
    protected static string $resource = PackageTemplateResource::class;

    protected function getRedirectUrl() : string {
        return $this->getResource()::getUrl('index');
    }
}
