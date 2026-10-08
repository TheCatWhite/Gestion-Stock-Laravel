<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la commande</title>
</head>
<body>

<h1>
    Modifier la commande {{ $order->order_number }}
</h1>

@if($errors->any())

    <div style="color: red;">

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
    action="{{ route('orders.update', $order) }}"
    method="POST"
>

    @csrf

    @method('PUT')

    <div>

        <label for="customer_name">
            Nom du client
        </label>

        <input
            type="text"
            name="customer_name"
            id="customer_name"
            value="{{ old('customer_name', $order->customer_name) }}"
        >

    </div>

    <br>

    <div>

        <label for="status">
            Statut
        </label>

        <select name="status" id="status">

            @foreach(\App\Enums\OrderStatus::cases() as $status)

                <option
                    value="{{ $status->value }}"
                    {{ old('status', $order->status->value) === $status->value ? 'selected' : '' }}
                >
                    {{ $status->value }}
                </option>

            @endforeach

        </select>

    </div>

    <br>

    <button type="submit">
        Enregistrer
    </button>

</form>

<hr>

<h2>Produits de la commande</h2>

<table border="1" cellpadding="10">

    <thead>

        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Sous-total</th>
        </tr>

    </thead>

    <tbody>

        @foreach($order->items as $item)

            <tr>

                <td>
                    {{ $item->product->name }}
                </td>

                <td>
                    {{ $item->quantity }}
                </td>

                <td>
                    {{ $item->unit_price }} €
                </td>

                <td>
                    {{ $item->subtotal }} €
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

<br>

<a href="{{ route('orders.show', $order) }}">
    Annuler
</a>

</body>
</html>