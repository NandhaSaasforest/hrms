<?php

namespace App\Filament\Resources\PayslipStructureResource\Pages;

use App\Filament\Resources\PayslipStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayslipStructure extends EditRecord
{
    protected static string $resource = PayslipStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getFormActions(): array
    {
        return [];
    }
}
