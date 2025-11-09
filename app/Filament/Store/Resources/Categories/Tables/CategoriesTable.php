<?php

namespace App\Filament\Store\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label(__('forms.category.image'))
                    ->circular()
                    ->size(40)
                    ->getStateUsing(function ($record) {
                        return $record->image_url;
                    }),

                TextColumn::make('id')
                    ->label(__('forms.common.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label(__('forms.category.name'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel(),

                TextColumn::make('description')
                    ->label(__('forms.category.description'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel()
                    ->limit(50)
                    ->toggleable(),

                ToggleColumn::make('is_active')
                    ->label(__('forms.category.is_active')),

                TextColumn::make('products_count')
                    ->label(__('forms.category.products_count'))
                    ->counts('products')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('forms.common.created_at'))
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label(__('forms.common.updated_at'))
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('forms.category.is_active'))
                    ->options([
                        'true' => __('forms.common.active'),
                        'false' => __('forms.common.inactive'),
                        'null' => __('forms.common.all'),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
