<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('forms.common.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label(__('forms.order.customer'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('store.name')
                    ->label(__('forms.order.store'))
                    ->sortable()
                    ->searchable()
                    ->translateLabel(),

                TextColumn::make('status')
                    ->label(__('forms.order.status'))
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('payment_status')
                    ->label(__('forms.order.payment_status'))
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('total_amount')
                    ->label(__('forms.order.total_amount'))
                    ->sortable()
                    ->money('USD'),

                TextColumn::make('delivery_amount')
                    ->label(__('forms.order.delivery_amount'))
                    ->sortable()
                    ->money('USD')
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
                SelectFilter::make('status')
                    ->label(__('forms.order.status'))
                    ->options([
                        'pending' => __('forms.order.statuses.pending'),
                        'processing' => __('forms.order.statuses.processing'),
                        'shipped' => __('forms.order.statuses.shipped'),
                        'delivered' => __('forms.order.statuses.delivered'),
                        'cancelled' => __('forms.order.statuses.cancelled'),
                    ]),

                SelectFilter::make('payment_status')
                    ->label(__('forms.order.payment_status'))
                    ->options([
                        'pending' => __('forms.order.payment_statuses.pending'),
                        'paid' => __('forms.order.payment_statuses.paid'),
                        'failed' => __('forms.order.payment_statuses.failed'),
                        'refunded' => __('forms.order.payment_statuses.refunded'),
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
