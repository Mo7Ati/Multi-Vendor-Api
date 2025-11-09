<?php

namespace App\Filament\Store\Resources\Additions\Pages;

use App\Filament\Store\Resources\Additions\AdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddition extends EditRecord
{
    protected static string $resource = AdditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
