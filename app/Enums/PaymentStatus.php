<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case Paid = 'paid';
    case Unpaid = 'unpaid';
    case Partial = 'partial';

    public function getLabel(): string
    {
        return match ($this) {
            self::Paid => 'مسدد',
            self::Unpaid => 'غير مسدد',
            self::Partial => 'جزئي',
        };
    }
}
