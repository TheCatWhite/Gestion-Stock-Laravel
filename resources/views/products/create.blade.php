<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
</head>
<body>

    <h1>Ajouter un produit</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">

        @csrf

        <div>
            <label>SKU :</label>
            <input
                type="text"
                name="sku"
                value="{{ old('sku') }}"
            >
        </div>

        <br>

        <div>
            <label>Nom :</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
            >
        </div>

        <br>

        <div>
            <label>Description :</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <br>

        <div>
            <label>Catégorie :</label>

            <select name="category_id">

                <option value="">-- Choisir une catégorie --</option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <br>

        <div>
            <label>Fournisseur :</label>

            <select name="supplier_id">

                <option value="">-- Choisir un fournisseur --</option>

                @foreach($suppliers as $supplier)
                    <option
                        value="{{ $supplier->id }}"
                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                    >
                        {{ $supplier->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <br>

        <div>
            <label>Prix d'achat :</label>
            <input
                type="number"
                step="0.01"
                name="purchase_price"
                value="{{ old('purchase_price') }}"
            >
        </div>

        <br>

        <div>
            <label>Prix de vente :</label>
            <input
                type="number"
                step="0.01"
                name="selling_price"
                value="{{ old('selling_price') }}"
            >
        </div>

        <br>

        <div>
            <label>Quantité en stock :</label>
            <input
                type="number"
                name="stock_quantity"
                value="{{ old('stock_quantity', 0) }}"
            >
        </div>

        <br>

        <div>
            <label>Seuil d'alerte :</label>
            <input
                type="number"
                name="alert_quantity"
                value="{{ old('alert_quantity', 5) }}"
            >
        </div>

        <br>

        <div>
            <label>
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    checked
                >
                Produit actif
            </label>
        </div>

        <br>

        <button type="submit">
            Ajouter le produit
        </button>

    </form>

    <br>

    <a href="{{ route('products.index') }}">
        Retour aux produits
    </a>

</body>
</html>