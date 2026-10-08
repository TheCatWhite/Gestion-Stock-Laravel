<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
</head>
<body>

<h1>Ajouter un produit à une commande</h1>

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('order-items.store') }}" method="POST">

    @csrf

    <div>
        <label for="order_id">
            Commande
        </label>

        <select name="order_id" id="order_id">

            <option value="">
                -- Choisir une commande --
            </option>

            @foreach($orders as $order)
                <option
                    value="{{ $order->id }}"
                    {{ old('order_id') == $order->id ? 'selected' : '' }}
                >
                    {{ $order->order_number }}
                    -
                    {{ $order->customer_name ?? 'Client anonyme' }}
                </option>
            @endforeach

        </select>
    </div>

    <br>

    <div>
        <label for="product_id">
            Produit
        </label>

        <select name="product_id" id="product_id">

            <option value="">
                -- Choisir un produit --
            </option>

            @foreach($products as $product)
                <option
                    value="{{ $product->id }}"
                    {{ old('product_id') == $product->id ? 'selected' : '' }}
                >
                    {{ $product->name }}
                    -
                    Stock : {{ $product->stock_quantity }}
                    -
                    {{ $product->selling_price }} €
                </option>
            @endforeach

        </select>
    </div>

    <br>

    <div>
        <label for="quantity">
            Quantité
        </label>

        <input
            type="number"
            name="quantity"
            id="quantity"
            min="1"
            value="{{ old('quantity', 1) }}"
        >
    </div>

    <br>

    <button type="submit">
        Ajouter
    </button>

</form>

<br>

<a href="{{ route('order-items.index') }}">
    Retour
</a>

</body>
</html>