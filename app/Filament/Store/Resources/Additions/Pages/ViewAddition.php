<?php

namespace App\Filament\Store\Resources\Additions\Pages;

use App\Filament\Store\Resources\Additions\AdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAddition extends ViewRecord
{
    protected static string $resource = AdditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
