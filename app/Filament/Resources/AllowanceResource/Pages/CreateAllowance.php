<?php

namespace App\Filament\Resources\AllowanceResource\Pages;

use App\Filament\Resources\AllowanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAllowance extends CreateRecord
{
    protected static string $resource = AllowanceResource::class;

}
