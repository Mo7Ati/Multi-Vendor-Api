<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Models\Customer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('forms.common.id'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('forms.common.name'))
                    ->searchable(),

                TextColumn::make('email')
                    ->label(__('forms.common.email'))
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label(__('forms.common.phone_number'))
                    ->searchable(),

                ToggleColumn::make('is_active')
                    ->label(__('forms.common.is_active')),


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
                    ->label(__('forms.common.is_active'))
                    ->options([
                        'true' => __('forms.common.active'),
                        'false' => __('forms.common.inactive'),
                        'null' => __('forms.common.all'),
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
