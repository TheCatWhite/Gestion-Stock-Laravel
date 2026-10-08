<?php

namespace Tests\Feature;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class OrderTotalsTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_number_and_customer_name_are_persisted(): void
    {
        $order = Order::factory()->create([
            'customer_name' => 'Ada Lovelace',
        ]);

        $this->assertNotEmpty($order->order_number);
        $this->assertTrue(str_starts_with($order->order_number, 'ORD-'));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_name' => 'Ada Lovelace',
        ]);
    }

    public function test_order_item_subtotal_and_order_total_are_calculated(): void
    {
        $order = Order::factory()->create();

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'quantity' => 2,
            'unit_price' => 12.50,
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'quantity' => 1,
            'unit_price' => 5.00,
        ]);

        $this->assertEquals(25.00, (float) $order->items()->first()->subtotal);
        $this->assertEquals(30.00, (float) $order->fresh()->total_amount);
    }

    public function test_store_product_request_validates_schema_fields(): void
    {
        $validator = Validator::make([], (new StoreProductRequest)->rules());

        $this->assertTrue($validator->errors()->has('sku'));
        $this->assertTrue($validator->errors()->has('purchase_price'));
        $this->assertTrue($validator->errors()->has('selling_price'));
        $this->assertTrue($validator->errors()->has('stock_quantity'));
        $this->assertFalse($validator->errors()->has('price'));
        $this->assertFalse($validator->errors()->has('stockQuantity'));
    }

    public function test_store_order_request_rejects_inactive_products(): void
    {
        $product = Product::factory()->inactive()->create(['stock_quantity' => 10]);

        $request = StoreOrderRequest::create('/', 'POST', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 1],
            ],
        ]);

        $validator = Validator::make($request->all(), $request->rules());

        foreach ($request->after() as $callback) {
            $callback($validator);
        }

        $this->assertTrue($validator->errors()->has('items.0.product_id'));
    }

    public function test_store_order_request_rejects_insufficient_stock(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 1]);

        $request = StoreOrderRequest::create('/', 'POST', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 5],
            ],
        ]);

        $validator = Validator::make($request->all(), $request->rules());

        foreach ($request->after() as $callback) {
            $callback($validator);
        }

        $this->assertTrue($validator->errors()->has('items.0.quantity'));
    }
}
