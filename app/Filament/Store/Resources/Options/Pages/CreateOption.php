<?php

namespace App\Filament\Store\Resources\Options\Pages;

use App\Filament\Store\Resources\Options\OptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOption extends CreateRecord
{
    protected static string $resource = OptionResource::class;
}
