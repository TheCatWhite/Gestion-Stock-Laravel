<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the order items.
     */
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();

        return view('order_items.index', [
            'orderItems' => $orderItems,
        ]);
    }

    /**
     * Show the form for creating a new order item.
     */
    public function create()
    {
        $orders = Order::all();

        $products = Product::active()
            ->where('stock_quantity', '>', 0)
            ->get();

        return view('order_items.create', [
            'orders' => $orders,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created order item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if (! $product->is_active) {
            return back()
                ->withErrors([
                    'product_id' => 'Ce produit n\'est pas disponible.',
                ])
                ->withInput();
        }

        if ($product->stock_quantity < $request->quantity) {
            return back()
                ->withErrors([
                    'quantity' => 'Stock insuffisant.',
                ])
                ->withInput();
        }

        $orderItem = OrderItem::create([
            'order_id' => $request->order_id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'unit_price' => $product->selling_price,
        ]);

        $product->decrement('stock_quantity', $request->quantity);

        return redirect()
            ->route('order-items.show', $orderItem)
            ->with('success', 'Produit ajouté à la commande.');
    }

    /**
     * Display the specified order item.
     */
    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product']);

        return view('order_items.show', [
            'orderItem' => $orderItem,
        ]);
    }

    /**
     * Show the form for editing the specified order item.
     */
    public function edit(OrderItem $orderItem)
    {
        $orders = Order::all();
        $products = Product::active()->get();

        $orderItem->load(['order', 'product']);

        return view('order_items.edit', [
            'orderItem' => $orderItem,
            'orders' => $orders,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified order item.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $orderItem->update([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()
            ->route('order-items.show', $orderItem)
            ->with('success', 'Ligne de commande modifiée.');
    }

    /**
     * Remove the specified order item.
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return redirect()
            ->route('order-items.index')
            ->with('success', 'Ligne de commande supprimée.');
    }
}