<?php

namespace App\Filament\Resources\StoreCategories\Pages;

use App\Filament\Resources\StoreCategories\StoreCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStoreCategory extends ViewRecord
{
    protected static string $resource = StoreCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
