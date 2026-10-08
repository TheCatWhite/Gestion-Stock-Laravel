<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with('items.product')
            ->latest()
            ->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $products = Product::active()
            ->where('stock_quantity', '>', 0)
            ->get();

        return view('orders.create', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created order.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = DB::transaction(function () use ($request) {

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'status' => OrderStatus::PENDING,
            ]);

            foreach ($request->items as $item) {

                $product = Product::findOrFail($item['product_id']);

                $quantity = (int) $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->selling_price,
                ]);

                $product->decrement('stock_quantity', $quantity);
            }

            return $order;
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Commande créée avec succès.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('items.product');

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $order->load('items.product');

        return view('orders.edit', [
            'order' => $order,
        ]);
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required'],
        ]);

        $order->update([
            'customer_name' => $request->customer_name,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Commande modifiée avec succès.');
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {

            $order->load('items');

            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)
                    ->increment('stock_quantity', $item->quantity);
            }

            $order->delete();
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Commande supprimée avec succès.');
    }
}