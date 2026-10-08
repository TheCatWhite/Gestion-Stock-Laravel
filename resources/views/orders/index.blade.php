<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commandes</title>
</head>
<body>

<h1>Commandes</h1>

<a href="{{ route('orders.create') }}">
    Créer une commande
</a>

<hr>

@if(session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

@if($orders->isEmpty())

    <p>Aucune commande trouvée.</p>

@else

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Numéro</th>
            <th>Client</th>
            <th>Nombre d'articles</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        @foreach($orders as $order)

            <tr>

                <td>
                    {{ $order->id }}
                </td>

                <td>
                    {{ $order->order_number }}
                </td>

                <td>
                    {{ $order->customer_name ?? 'Client anonyme' }}
                </td>

                <td>
                    {{ $order->items->count() }}
                </td>

                <td>
                    {{ $order->total_amount }} €
                </td>

                <td>
                    {{ $order->status->value }}
                </td>

                <td>
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </td>

                <td>

                    <a href="{{ route('orders.show', $order) }}">
                        Voir
                    </a>

                    |

                    <a href="{{ route('orders.edit', $order) }}">
                        Modifier
                    </a>

                    |

                    <form
                        action="{{ route('orders.destroy', $order) }}"
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