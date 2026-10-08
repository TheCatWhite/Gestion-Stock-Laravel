<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits</title>
</head>
<body>

    <h1>Liste des produits</h1>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('products.create') }}">
        Ajouter un produit
    </a>

    <br><br>

    @if($products->count() > 0)

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Fournisseur</th>
                    <th>Prix achat</th>
                    <th>Prix vente</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>

                        <td>{{ $product->sku }}</td>

                        <td>{{ $product->name }}</td>

                        <td>
                            {{ $product->category->name ?? 'Aucune' }}
                        </td>

                        <td>
                            {{ $product->supplier->name ?? 'Aucun' }}
                        </td>

                        <td>{{ $product->purchase_price }}</td>

                        <td>{{ $product->selling_price }}</td>

                        <td>
                            {{ $product->stock_quantity }}

                            @if($product->isLowStock())
                                <strong style="color: red;">
                                    Stock faible
                                </strong>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('products.show', $product) }}">
                                Voir
                            </a>

                            |

                            <a href="{{ route('products.edit', $product) }}">
                                Modifier
                            </a>

                            |

                            <form
                                action="{{ route('products.destroy', $product) }}"
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

    @else

        <p>Aucun produit enregistré.</p>

    @endif

</body>
</html>