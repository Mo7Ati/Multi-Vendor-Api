<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('media')
                    ->label(__('forms.product.image'))
                    ->circular()
                    ->size(40)
                    ->getStateUsing(function ($record) {
                        return $record->getFirstMediaUrl();
                    }),

                TextColumn::make('name')
                    ->label(__('forms.product.name'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel(),

                TextColumn::make('store.name')
                    ->label(__('forms.product.store'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel(),

                TextColumn::make('category.name')
                    ->label(__('forms.product.category'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel(),

                TextColumn::make('price')
                    ->label(__('forms.product.price'))
                    ->sortable()
                    ->money('USD'),

                TextColumn::make('compare_price')
                    ->label(__('forms.product.compare_price'))
                    ->sortable()
                    ->money('USD')
                    ->toggleable(),

                TextColumn::make('quantity')
                    ->label(__('forms.product.quantity'))
                    ->sortable()
                    ->numeric(),

                ToggleColumn::make('is_active')
                    ->label(__('forms.product.is_active')),

                ToggleColumn::make('is_accepted')
                    ->label(__('forms.product.is_accepted')),

                TextColumn::make('created_at')
                    ->label(__('forms.common.created_at'))
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label(__('forms.common.updated_at'))
                    ->sortable()
                    ->dateTime('d-m-Y')
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('forms.product.is_active'))
                    ->options([
                        'true' => __('forms.common.active'),
                        'false' => __('forms.common.inactive'),
                        'null' => __('forms.common.all'),
                    ]),

                TernaryFilter::make('is_accepted')
                    ->label(__('forms.product.is_accepted'))
                    ->options([
                        'true' => __('forms.product.accepted'),
                        'false' => __('forms.product.pending'),
                        'null' => __('forms.common.all'),
                    ]),

                SelectFilter::make('store_id')
                    ->label(__('forms.product.store'))
                    ->relationship('store', 'name')
                    ->searchable(),

                SelectFilter::make('category_id')
                    ->label(__('forms.product.category'))
                    ->relationship('category', 'name')
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
