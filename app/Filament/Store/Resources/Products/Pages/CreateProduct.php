<?php

namespace App\Filament\Store\Resources\Products\Pages;

use App\Filament\Store\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    protected array $additionsData = [];
    protected array $optionsData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract additions and options data for sync
        $additions = $data['additions'] ?? [];
        $options = $data['options'] ?? [];

        // Remove from main data array to prevent mass assignment
        unset($data['additions'], $data['options']);

        // Store for after create
        $this->additionsData = $additions;
        $this->optionsData = $options;

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->getRecord();

        // Sync additions with pivot data
        if (!empty($this->additionsData)) {
            $additionsSync = [];
            foreach ($this->additionsData as $addition) {
                if (!empty($addition['addition_id']) && isset($addition['price'])) {
                    $additionsSync[$addition['addition_id']] = ['price' => $addition['price']];
                }
            }
            $record->additions()->sync($additionsSync);
        }

        // Sync options with pivot data
        if (!empty($this->optionsData)) {
            $optionsSync = [];
            foreach ($this->optionsData as $option) {
                if (!empty($option['option_id']) && isset($option['price'])) {
                    $optionsSync[$option['option_id']] = ['price' => $option['price']];
                }
            }
            $record->options()->sync($optionsSync);
        }
    }
}
