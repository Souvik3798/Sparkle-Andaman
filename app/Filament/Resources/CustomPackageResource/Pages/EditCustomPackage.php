<?php

namespace App\Filament\Resources\CustomPackageResource\Pages;

use App\Filament\Resources\CustomPackageResource;
use Filament\Actions;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class EditCustomPackage extends EditRecord
{
    protected static string $resource = CustomPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('Save as New')
            ->action(fn() => $this->saveAsNew($this->record))
            ->successNotificationTitle('New Data Stored Succesfully')
        ];
    }

    public function saveAsNew($record){
        $model = $this->getModel();
        $inputValues = $this->form->getState();
        $newModel = $record->replicate();
        // $inputValues =  Request::all();
        // $inputValues = [];
        // foreach ($this->form->getComponents() as $tabs) {
        //     foreach ($tabs->getFields() as $component) {
        //         $name = $component->getName();
        //         if($name){
        //             $inputValues[$name] = $component->getValue();
        //         }
        //     }
        // }
        unset($inputValues['id']);
        $newModel->fill($inputValues);
        $newModel->save();
        $this->redirect(route('filament.admin.resources.custom-packages.index'));
    }

}
