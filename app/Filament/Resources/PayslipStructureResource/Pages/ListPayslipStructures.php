<?php

namespace App\Filament\Resources\PayslipStructureResource\Pages;

use App\Filament\Resources\PayslipStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayslipStructures extends ListRecords
{
    protected static string $resource = PayslipStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Generate Payslip'),
        ];
    }
}
