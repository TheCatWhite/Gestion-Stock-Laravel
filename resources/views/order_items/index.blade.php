<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Lignes de commande</title>
</head>
<body>

<h1>Lignes de commande</h1>

<a href="{{ route('order-items.create') }}">
    Ajouter un produit à une commande
</a>

<hr>

@if(session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

@if($orderItems->isEmpty())
    <p>Aucune ligne de commande.</p>
@else

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Commande</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Sous-total</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orderItems as $orderItem)
            <tr>
                <td>{{ $orderItem->id }}</td>

                <td>
                    {{ $orderItem->order->order_number }}
                </td>

                <td>
                    {{ $orderItem->product->name }}
                </td>

                <td>
                    {{ $orderItem->quantity }}
                </td>

                <td>
                    {{ $orderItem->unit_price }} €
                </td>

                <td>
                    {{ $orderItem->subtotal }} €
                </td>

                <td>
                    <a href="{{ route('order-items.show', $orderItem) }}">
                        Voir
                    </a>

                    |

                    <a href="{{ route('order-items.edit', $orderItem) }}">
                        Modifier
                    </a>

                    |

                    <form
                        action="{{ route('order-items.destroy', $orderItem) }}"
                        method="POST"
                        style="display: inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endif

</body>
</html>