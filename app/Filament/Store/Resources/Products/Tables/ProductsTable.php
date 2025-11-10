<?php

namespace App\Filament\Store\Resources\Products\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
                ImageColumn::make('image')
                    ->label(__('forms.product.image'))
                    ->circular()
                    ->size(60)
                    ->getStateUsing(function ($record) {
                        return $record->getFirstMediaUrl('product-images');
                    }),

                TextColumn::make('name')
                    ->label(__('forms.product.name'))
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

                TextColumn::make('quantity')
                    ->label(__('forms.product.quantity'))
                    ->sortable()
                    ->numeric(),

                ToggleColumn::make('is_active')
                    ->label(__('forms.product.is_active')),

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

                SelectFilter::make('category_id')
                    ->label(__('forms.product.category'))
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
