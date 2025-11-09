<?php

namespace App\Filament\Store\Resources\Options\Pages;

use App\Filament\Store\Resources\Options\OptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOption extends EditRecord
{
    protected static string $resource = OptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
