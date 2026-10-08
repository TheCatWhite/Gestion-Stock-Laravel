<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une commande</title>
</head>
<body>

<h1>Créer une commande</h1>

@if($errors->any())

    <div style="color: red;">

        <strong>Erreurs :</strong>

        <ul>

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif

<form
    action="{{ route('orders.store') }}"
    method="POST"
>

    @csrf

    <div>

        <label for="customer_name">
            Nom du client
        </label>

        <input
            type="text"
            name="customer_name"
            id="customer_name"
            value="{{ old('customer_name') }}"
        >

    </div>

    <br>

    <h2>Produits</h2>

    <div id="items">

        @php
            $oldItems = old('items', [
                [
                    'product_id' => '',
                    'quantity' => 1,
                ]
            ]);
        @endphp

        @foreach($oldItems as $index => $item)

            <div class="item" style="margin-bottom: 15px;">

                <label>
                    Produit
                </label>

                <select
                    name="items[{{ $index }}][product_id]"
                >

                    <option value="">
                        -- Choisir un produit --
                    </option>

                    @foreach($products as $product)

                        <option
                            value="{{ $product->id }}"
                            {{ ($item['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                        >

                            {{ $product->name }}

                            -
                            {{ $product->selling_price }} €

                            -
                            Stock :
                            {{ $product->stock_quantity }}

                        </option>

                    @endforeach

                </select>

                <label>
                    Quantité
                </label>

                <input
                    type="number"
                    name="items[{{ $index }}][quantity]"
                    min="1"
                    value="{{ $item['quantity'] ?? 1 }}"
                >

            </div>

        @endforeach

    </div>

    <button
        type="button"
        onclick="addItem()"
    >
        + Ajouter un produit
    </button>

    <br>
    <br>

    <button type="submit">
        Créer la commande
    </button>

</form>

<br>

<a href="{{ route('orders.index') }}">
    Retour aux commandes
</a>


<script>

let itemIndex = {{ count($oldItems) }};

function addItem()
{
    const container = document.getElementById('items');

    const div = document.createElement('div');

    div.classList.add('item');

    div.style.marginBottom = '15px';

    div.innerHTML = `
        <label>
            Produit
        </label>

        <select name="items[${itemIndex}][product_id]">

            <option value="">
                -- Choisir un produit --
            </option>

            @foreach($products as $product)

                <option value="{{ $product->id }}">

                    {{ $product->name }}
                    -
                    {{ $product->selling_price }} €
                    -
                    Stock : {{ $product->stock_quantity }}

                </option>

            @endforeach

        </select>

        <label>
            Quantité
        </label>

        <input
            type="number"
            name="items[${itemIndex}][quantity]"
            min="1"
            value="1"
        >

        <button
            type="button"
            onclick="this.parentElement.remove()"
        >
            Supprimer
        </button>
    `;

    container.appendChild(div);

    itemIndex++;
}

</script>

</body>
</html>