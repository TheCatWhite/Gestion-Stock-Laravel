<?php

namespace Tests\Feature;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use LogicException;
use Tests\TestCase;

class ProductStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created_with_aligned_schema_fields(): void
    {
        $product = Product::factory()->create([
            'sku' => 'SKU-ABC123',
            'purchase_price' => 10.50,
            'selling_price' => 15.00,
            'stock_quantity' => 20,
            'alert_quantity' => 5,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'sku' => 'SKU-ABC123',
            'purchase_price' => 10.50,
            'selling_price' => 15.00,
            'stock_quantity' => 20,
            'alert_quantity' => 5,
            'is_active' => true,
        ]);
    }

    public function test_incoming_movement_increases_product_stock(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        StockMovement::factory()->create([
            'product_id' => $product->id,
            'type' => StockMovementType::In,
            'quantity' => 5,
        ]);

        $this->assertSame(15, $product->fresh()->stock_quantity);
    }

    public function test_outgoing_movement_decreases_product_stock(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        StockMovement::factory()->create([
            'product_id' => $product->id,
            'type' => StockMovementType::Out,
            'quantity' => 4,
        ]);

        $this->assertSame(6, $product->fresh()->stock_quantity);
    }

    public function test_outgoing_movement_is_rejected_when_stock_is_insufficient(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 2]);

        $this->expectException(InvalidArgumentException::class);

        StockMovement::query()->create([
            'product_id' => $product->id,
            'user_id' => User::factory()->create()->id,
            'type' => StockMovementType::Out,
            'quantity' => 5,
        ]);
    }

    public function test_negative_adjustment_decreases_stock(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        StockMovement::factory()->create([
            'product_id' => $product->id,
            'type' => StockMovementType::Adjustment,
            'quantity' => -3,
            'reason' => 'Inventory correction',
        ]);

        $this->assertSame(7, $product->fresh()->stock_quantity);
    }

    public function test_is_low_stock_uses_quantity_columns(): void
    {
        $product = Product::factory()->lowStock()->create();

        $this->assertTrue($product->isLowStock());
        $this->assertTrue(Product::query()->lowStock()->whereKey($product)->exists());
    }

    public function test_stock_movements_cannot_be_updated(): void
    {
        $movement = StockMovement::factory()->create();

        $this->expectException(LogicException::class);

        $movement->update(['reason' => 'changed']);
    }

    public function test_stock_movements_cannot_be_deleted(): void
    {
        $movement = StockMovement::factory()->create();

        $this->expectException(LogicException::class);

        $movement->delete();
    }
}
