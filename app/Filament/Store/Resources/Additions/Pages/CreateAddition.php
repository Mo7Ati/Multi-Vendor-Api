<?php

namespace App\Filament\Store\Resources\Additions\Pages;

use App\Filament\Store\Resources\Additions\AdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAddition extends CreateRecord
{
    protected static string $resource = AdditionResource::class;
}
