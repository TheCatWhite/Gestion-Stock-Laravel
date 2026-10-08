<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderItemService;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Afficher toutes les lignes de commande.
     */
    public function index()
    {
        $orderItems = OrderItem::with([
            'order',
            'product',
        ])
            ->latest()
            ->get();

        return view('order_items.index', [
            'orderItems' => $orderItems,
        ]);
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        $orders = Order::latest()->get();

        $products = Product::active()
            ->where('stock_quantity', '>', 0)
            ->get();

        return view('order_items.create', [
            'orders' => $orders,
            'products' => $products,
        ]);
    }

    /**
     * Ajouter une ligne de commande.
     */
    public function store(
        Request $request,
        OrderItemService $orderItemService
    ) {
        $request->validate([
            'order_id' => [
                'required',
                'exists:orders,id',
            ],

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $order = Order::findOrFail(
            $request->order_id
        );

        $product = Product::findOrFail(
            $request->product_id
        );

        try {

            $orderItem = $orderItemService->addItem(
                $order,
                $product,
                (int) $request->quantity
            );

        } catch (\RuntimeException $e) {

            return back()
                ->withErrors([
                    'quantity' => $e->getMessage(),
                ])
                ->withInput();
        }

        return redirect()
            ->route('order-items.show', $orderItem)
            ->with(
                'success',
                'Produit ajouté à la commande.'
            );
    }

    /**
     * Afficher une ligne de commande.
     */
    public function show(OrderItem $orderItem)
    {
        $orderItem->load([
            'order',
            'product',
        ]);

        return view('order_items.show', [
            'orderItem' => $orderItem,
        ]);
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(OrderItem $orderItem)
    {
        $orders = Order::latest()->get();

        $products = Product::active()
            ->get();

        $orderItem->load([
            'order',
            'product',
        ]);

        return view('order_items.edit', [
            'orderItem' => $orderItem,
            'orders' => $orders,
            'products' => $products,
        ]);
    }

    /**
     * Modifier une ligne de commande.
     */
    public function update(
        Request $request,
        OrderItem $orderItem,
        OrderItemService $orderItemService
    ) {
        $request->validate([
            'order_id' => [
                'required',
                'exists:orders,id',
            ],

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $order = Order::findOrFail(
            $request->order_id
        );

        $product = Product::findOrFail(
            $request->product_id
        );

        try {

            $orderItemService->updateItem(
                $orderItem,
                $order,
                $product,
                (int) $request->quantity
            );

        } catch (\RuntimeException $e) {

            return back()
                ->withErrors([
                    'quantity' => $e->getMessage(),
                ])
                ->withInput();
        }

        return redirect()
            ->route('order-items.show', $orderItem)
            ->with(
                'success',
                'Ligne de commande modifiée.'
            );
    }

    /**
     * Supprimer une ligne de commande.
     */
    public function destroy(
        OrderItem $orderItem,
        OrderItemService $orderItemService
    ) {
        $orderItemService->removeItem(
            $orderItem
        );

        return redirect()
            ->route('order-items.index')
            ->with(
                'success',
                'Ligne de commande supprimée.'
            );
    }
}