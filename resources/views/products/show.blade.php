<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
</head>
<body>

    <h1>{{ $product->name }}</h1>

    <p>
        <strong>ID :</strong>
        {{ $product->id }}
    </p>

    <p>
        <strong>SKU :</strong>
        {{ $product->sku }}
    </p>

    <p>
        <strong>Description :</strong>
        {{ $product->description }}
    </p>

    <p>
        <strong>Catégorie :</strong>
        {{ $product->category->name ?? 'Aucune' }}
    </p>

    <p>
        <strong>Fournisseur :</strong>
        {{ $product->supplier->name ?? 'Aucun' }}
    </p>

    <p>
        <strong>Prix d'achat :</strong>
        {{ $product->purchase_price }}
    </p>

    <p>
        <strong>Prix de vente :</strong>
        {{ $product->selling_price }}
    </p>

    <p>
        <strong>Stock :</strong>
        {{ $product->stock_quantity }}
    </p>

    <p>
        <strong>Seuil d'alerte :</strong>
        {{ $product->alert_quantity }}
    </p>

    <p>
        <strong>Statut :</strong>

        @if($product->is_active)
            Actif
        @else
            Inactif
        @endif
    </p>

    @if($product->isLowStock())
        <p style="color: red;">
            ⚠ Attention : stock faible !
        </p>
    @endif

    <br>

    <a href="{{ route('products.edit', $product) }}">
        Modifier
    </a>

    <br><br>

    <a href="{{ route('products.index') }}">
        Retour à la liste
    </a>

</body>
</html>