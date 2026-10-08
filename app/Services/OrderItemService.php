<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderItemService
{
    /**
     * Ajouter une ligne à une commande.
     */
    public function addItem(
        Order $order,
        Product $product,
        int $quantity
    ): OrderItem {
        return DB::transaction(function () use ($order, $product, $quantity) {

            // Vérifier que le produit est actif
            if (! $product->is_active) {
                throw new \RuntimeException(
                    'Ce produit n\'est pas disponible.'
                );
            }

            // Vérifier le stock
            if ($product->stock_quantity < $quantity) {
                throw new \RuntimeException(
                    'Stock insuffisant.'
                );
            }

            // Créer la ligne de commande
            $orderItem = $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->selling_price,
            ]);

            // Retirer le stock
            $product->decrement(
                'stock_quantity',
                $quantity
            );

            return $orderItem;
        });
    }

    /**
     * Modifier une ligne de commande.
     */
    public function updateItem(
        OrderItem $orderItem,
        Order $order,
        Product $product,
        int $quantity
    ): OrderItem {
        return DB::transaction(function () use (
            $orderItem,
            $order,
            $product,
            $quantity
        ) {

            $oldProduct = $orderItem->product;
            $oldQuantity = $orderItem->quantity;

            /*
             * 1. Rendre l'ancien stock.
             */
            $oldProduct->increment(
                'stock_quantity',
                $oldQuantity
            );

            /*
             * 2. Vérifier le nouveau produit.
             */
            if (! $product->is_active) {
                throw new \RuntimeException(
                    'Ce produit n\'est pas disponible.'
                );
            }

            /*
             * 3. Vérifier le nouveau stock.
             */
            if ($product->stock_quantity < $quantity) {
                throw new \RuntimeException(
                    'Stock insuffisant.'
                );
            }

            /*
             * 4. Modifier la ligne.
             */
            $orderItem->update([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->selling_price,
            ]);

            /*
             * 5. Retirer le nouveau stock.
             */
            $product->decrement(
                'stock_quantity',
                $quantity
            );

            return $orderItem->fresh([
                'order',
                'product',
            ]);
        });
    }

    /**
     * Supprimer une ligne et remettre le stock.
     */
    public function removeItem(OrderItem $orderItem): void
    {
        DB::transaction(function () use ($orderItem) {

            $product = $orderItem->product;

            /*
             * Rendre le stock.
             */
            $product->increment(
                'stock_quantity',
                $orderItem->quantity
            );

            /*
             * Supprimer la ligne.
             */
            $orderItem->delete();
        });
    }
}