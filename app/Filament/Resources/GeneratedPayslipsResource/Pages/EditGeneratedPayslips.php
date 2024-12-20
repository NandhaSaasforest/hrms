<?php

namespace App\Filament\Resources\GeneratedPayslipsResource\Pages;

use App\Filament\Resources\GeneratedPayslipsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeneratedPayslips extends EditRecord
{
    protected static string $resource = GeneratedPayslipsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
