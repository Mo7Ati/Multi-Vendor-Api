<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PREPARING = 'preparing';
    case ON_THE_WAY = 'on_the_way';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => __('general.order_statuses.pending'),
            self::PREPARING => __('general.order_statuses.preparing'),
            self::ON_THE_WAY => __('general.order_statuses.on_the_way'),
            self::COMPLETED => __('general.order_statuses.completed'),
            self::CANCELLED => __('general.order_statuses.cancelled'),
            self::REJECTED => __('general.order_statuses.rejected'),
        };
    }
    public static function getAll(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
