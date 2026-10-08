<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ligne de commande</title>
</head>
<body>

<h1>Ligne de commande #{{ $orderItem->id }}</h1>

<p>
    <strong>Commande :</strong>
    {{ $orderItem->order->order_number }}
</p>

<p>
    <strong>Client :</strong>
    {{ $orderItem->order->customer_name ?? 'Client anonyme' }}
</p>

<p>
    <strong>Produit :</strong>
    {{ $orderItem->product->name }}
</p>

<p>
    <strong>Quantité :</strong>
    {{ $orderItem->quantity }}
</p>

<p>
    <strong>Prix unitaire :</strong>
    {{ $orderItem->unit_price }} €
</p>

<p>
    <strong>Sous-total :</strong>
    {{ $orderItem->subtotal }} €
</p>

<hr>

<a href="{{ route('order-items.edit', $orderItem) }}">
    Modifier
</a>

|

<a href="{{ route('order-items.index') }}">
    Retour
</a>

</body>
</html>