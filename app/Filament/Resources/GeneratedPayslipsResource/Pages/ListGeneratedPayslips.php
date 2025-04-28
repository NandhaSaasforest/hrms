<?php

namespace App\Filament\Resources\GeneratedPayslipsResource\Pages;

use App\Filament\Resources\GeneratedPayslipsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeneratedPayslips extends ListRecords
{
    protected static string $resource = GeneratedPayslipsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
