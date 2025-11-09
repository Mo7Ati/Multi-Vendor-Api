<?php

namespace App\Filament\Store\Resources\Additions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AdditionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('forms.common.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label(__('forms.addition.name'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel(),

                ToggleColumn::make('is_active')
                    ->label(__('forms.addition.is_active')),

                TextColumn::make('products_count')
                    ->label(__('forms.addition.products_count'))
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
                    ->label(__('forms.addition.is_active'))
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
