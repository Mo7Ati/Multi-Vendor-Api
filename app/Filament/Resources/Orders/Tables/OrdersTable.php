<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
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
                    ->searchable(),

                TextColumn::make('store.name')
                    ->label(__('forms.order.store'))
                    ->searchable()
                    ->translateLabel(),

                TextColumn::make('status')
                    ->label(__('forms.order.status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        OrderStatusEnum::PENDING->value => 'warning',
                        OrderStatusEnum::PREPARING->value => 'info',
                        OrderStatusEnum::ON_THE_WAY->value => 'primary',
                        OrderStatusEnum::COMPLETED->value => 'success',
                        OrderStatusEnum::CANCELLED->value => 'danger',
                        OrderStatusEnum::REJECTED->value => 'gray',
                    }),

                TextColumn::make('payment_status')
                    ->label(__('forms.order.payment_status'))
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        PaymentStatusEnum::Unpaid->value => 'warning',
                        PaymentStatusEnum::Paid->value => 'success',
                        PaymentStatusEnum::Failed->value => 'danger',
                        PaymentStatusEnum::Refunded->value => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('total_amount')
                    ->label(__('forms.order.total_amount'))
                    ->sortable()
                    ->money('USD'),


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
                SelectFilter::make('status')
                    ->label(__('forms.order.status'))
                    ->options(OrderStatusEnum::getAll()),

                SelectFilter::make('payment_status')
                    ->label(__('forms.order.payment_status'))
                    ->options(PaymentStatusEnum::getAll()),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
