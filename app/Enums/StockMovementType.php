<?php

namespace App\Enums;

enum StockMovementType: string
{
    case In = 'in';
    case Out = 'out';
    case Adjustment = 'adjustment';

    public function signedQuantity(int $quantity): int
    {
        return match ($this) {
            self::In => abs($quantity),
            self::Out => -abs($quantity),
            self::Adjustment => $quantity,
        };
    }
}
