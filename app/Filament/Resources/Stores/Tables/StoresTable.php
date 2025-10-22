<?php

namespace App\Filament\Resources\Stores\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use App\Models\StoreCategory;

class StoresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(__('forms.store.logo'))
                    ->circular()
                    ->size(40),

                TextColumn::make('name')
                    ->label(__('forms.common.name'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel(),

                TextColumn::make('email')
                    ->label(__('forms.common.email'))
                    ->sortable()
                    ->searchable()
                    ->copyable(),

                TextColumn::make('phone')
                    ->label(__('forms.store.phone'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),


                ToggleColumn::make('is_active')
                    ->label(__('forms.common.is_active')),

                TextColumn::make('products_count')
                    ->label(__('forms.store.products_count'))
                    ->counts('products')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('forms.common.created_at'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('updated_at')
                    ->label(__('forms.common.updated_at'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('forms.store.is_active'))
                    ->options([
                        'true' => __('forms.common.active'),
                        'false' => __('forms.common.inactive'),
                        'null' => __('forms.common.all'),
                    ]),

                SelectFilter::make('category_id')
                    ->label(__('forms.store.category'))
                    ->options(StoreCategory::all()->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
