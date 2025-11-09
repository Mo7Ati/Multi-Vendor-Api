<?php

namespace App\Filament\Store\Resources\Options\Pages;

use App\Filament\Store\Resources\Options\OptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOption extends ViewRecord
{
    protected static string $resource = OptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
