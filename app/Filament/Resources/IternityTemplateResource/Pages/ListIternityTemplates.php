<?php

namespace App\Filament\Resources\IternityTemplateResource\Pages;

use App\Filament\Resources\IternityTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIternityTemplates extends ListRecords
{
    protected static string $resource = IternityTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
