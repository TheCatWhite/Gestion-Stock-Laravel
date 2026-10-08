<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier {{ $product->name }}</title>
</head>
<body>

    <h1>Modifier le produit</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('products.update', $product) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div>
            <label>SKU :</label>

            <input
                type="text"
                name="sku"
                value="{{ old('sku', $product->sku) }}"
            >
        </div>

        <br>

        <div>
            <label>Nom :</label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $product->name) }}"
            >
        </div>

        <br>

        <div>
            <label>Description :</label>

            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </div>

        <br>

        <div>
            <label>Catégorie :</label>

            <select name="category_id">

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
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

                @foreach($suppliers as $supplier)
                    <option
                        value="{{ $supplier->id }}"
                        {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}
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
                value="{{ old('purchase_price', $product->purchase_price) }}"
            >
        </div>

        <br>

        <div>
            <label>Prix de vente :</label>

            <input
                type="number"
                step="0.01"
                name="selling_price"
                value="{{ old('selling_price', $product->selling_price) }}"
            >
        </div>

        <br>

        <div>
            <label>Quantité en stock :</label>

            <input
                type="number"
                name="stock_quantity"
                value="{{ old('stock_quantity', $product->stock_quantity) }}"
            >
        </div>

        <br>

        <div>
            <label>Seuil d'alerte :</label>

            <input
                type="number"
                name="alert_quantity"
                value="{{ old('alert_quantity', $product->alert_quantity) }}"
            >
        </div>

        <br>

        <div>
            <label>
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ $product->is_active ? 'checked' : '' }}
                >
                Produit actif
            </label>
        </div>

        <br>

        <button type="submit">
            Enregistrer les modifications
        </button>

    </form>

    <br>

    <a href="{{ route('products.show', $product) }}">
        Annuler
    </a>

</body>
</html>