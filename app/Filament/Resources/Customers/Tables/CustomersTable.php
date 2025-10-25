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
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label(__('forms.customer.name'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('mobile')
                    ->label(__('forms.customer.mobile'))
                    ->sortable()
                    ->searchable()
                    ->copyable(),

                ToggleColumn::make('is_active')
                    ->label(__('forms.customer.is_active')),

                ToggleColumn::make('mobile_verified')
                    ->label(__('forms.customer.mobile_verified')),

                TextColumn::make('mobile_type')
                    ->label(__('forms.customer.mobile_type'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('timezone')
                    ->label(__('forms.customer.timezone'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('last_seen_at')
                    ->label(__('forms.customer.last_seen_at'))
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),

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
                    ->label(__('forms.customer.is_active'))
                    ->options([
                        'true' => __('forms.common.active'),
                        'false' => __('forms.common.inactive'),
                        'null' => __('forms.common.all'),
                    ]),

                TernaryFilter::make('mobile_verified')
                    ->label(__('forms.customer.mobile_verified'))
                    ->options([
                        'true' => __('forms.customer.verified'),
                        'false' => __('forms.customer.unverified'),
                        'null' => __('forms.common.all'),
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
