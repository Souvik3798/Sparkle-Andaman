<?php

namespace App\Filament\Resources\IternityTemplateResource\Pages;

use App\Filament\Resources\IternityTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIternityTemplate extends CreateRecord
{
    protected static string $resource = IternityTemplateResource::class;

    protected function getRedirectUrl() : string {
        return $this->getResource()::getUrl('index');
    }
}
