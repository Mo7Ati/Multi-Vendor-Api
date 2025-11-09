<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case Unpaid = 'unpaid';
    case Paid = 'paid';
    case Failed = 'failed';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Unpaid => __('general.payment_statuses.unpaid'),
            self::Paid => __('general.payment_statuses.paid'),
            self::Failed => __('general.payment_statuses.failed'),
            self::Refunded => __('general.payment_statuses.refunded'),
        };
    }
    public static function getAll(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
