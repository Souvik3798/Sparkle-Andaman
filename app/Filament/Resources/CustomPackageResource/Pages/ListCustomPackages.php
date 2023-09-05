<?php

namespace App\Filament\Resources\CustomPackageResource\Pages;

use App\Filament\Resources\CustomPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomPackages extends ListRecords
{
    protected static string $resource = CustomPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
