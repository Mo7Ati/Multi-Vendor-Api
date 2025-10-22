<?php

namespace App\Filament\Resources\StoreCategories\Pages;

use App\Filament\Resources\StoreCategories\StoreCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoreCategories extends ListRecords
{
    protected static string $resource = StoreCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
