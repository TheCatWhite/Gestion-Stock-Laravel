<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\StockMovement;
use InvalidArgumentException;
use LogicException;

class StockMovementObserver
{
    /**
     * Apply the movement to the product quantity before the audit row is stored.
     */
    public function creating(StockMovement $stockMovement): void
    {
        $product = Product::query()
            ->whereKey($stockMovement->product_id)
            ->lockForUpdate()
            ->firstOrFail();

        $delta = $stockMovement->signedQuantity();

        if ($delta === 0) {
            throw new InvalidArgumentException('Movement quantity cannot be zero.');
        }

        $newQuantity = $product->stock_quantity + $delta;

        if ($newQuantity < 0) {
            throw new InvalidArgumentException('Insufficient stock for this movement.');
        }

        $product->forceFill([
            'stock_quantity' => $newQuantity,
        ])->save();
    }

    public function updating(StockMovement $stockMovement): void
    {
        throw new LogicException('Stock movements cannot be updated.');
    }

    public function deleting(StockMovement $stockMovement): void
    {
        throw new LogicException('Stock movements cannot be deleted.');
    }
}
