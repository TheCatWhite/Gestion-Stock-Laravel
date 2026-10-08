<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande {{ $order->order_number }}</title>
</head>
<body>

<h1>
    Commande {{ $order->order_number }}
</h1>

@if(session('success'))

    <p style="color: green;">
        {{ session('success') }}
    </p>

@endif

<h2>Informations</h2>

<p>
    <strong>Numéro :</strong>
    {{ $order->order_number }}
</p>

<p>
    <strong>Client :</strong>
    {{ $order->customer_name ?? 'Client anonyme' }}
</p>

<p>
    <strong>Statut :</strong>
    {{ $order->status->value }}
</p>

<p>
    <strong>Date :</strong>
    {{ $order->created_at->format('d/m/Y H:i') }}
</p>

<hr>

<h2>Produits commandés</h2>

@if($order->items->isEmpty())

    <p>Aucun produit dans cette commande.</p>

@else

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

@endif

<hr>

<h2>
    Total :
    {{ $order->total_amount }} €
</h2>

<hr>

<a href="{{ route('orders.edit', $order) }}">
    Modifier la commande
</a>

|

<a href="{{ route('orders.index') }}">
    Retour
</a>

<form
    action="{{ route('orders.destroy', $order) }}"
    method="POST"
    style="margin-top: 15px;"
>

    @csrf

    @method('DELETE')

    <button type="submit">
        Supprimer la commande
    </button>

</form>

</body>
</html>