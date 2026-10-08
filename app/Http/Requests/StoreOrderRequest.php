<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                /** @var array<int, array{product_id: mixed, quantity: mixed}> $items */
                $items = $this->input('items', []);
                $productIds = collect($items)->pluck('product_id');
                $products = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

                $requestedQuantities = [];

                foreach ($items as $item) {
                    $productId = (int) $item['product_id'];
                    $requestedQuantities[$productId] = ($requestedQuantities[$productId] ?? 0) + (int) $item['quantity'];
                }

                foreach ($items as $index => $item) {
                    $product = $products->get((int) $item['product_id']);

                    if ($product === null) {
                        continue;
                    }

                    if (! $product->is_active) {
                        $validator->errors()->add("items.{$index}.product_id", 'This product is not available.');
                    }

                    if ($product->stock_quantity < ($requestedQuantities[$product->id] ?? 0)) {
                        $validator->errors()->add("items.{$index}.quantity", 'Insufficient stock.');
                    }
                }
            },
        ];
    }
}
