<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier {{ $supplier->name }}</title>
</head>
<body>

    <h1>Modifier le fournisseur</h1>

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
        action="{{ route('suppliers.update', $supplier) }}"
        method="POST"
    >

        @csrf

        @method('PUT')

        <div>
            <label for="name">
                Nom :
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $supplier->name) }}"
            >
        </div>

        <br>

        <div>
            <label for="email">
                Email :
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $supplier->email) }}"
            >
        </div>

        <br>

        <div>
            <label for="phone">
                Téléphone :
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone', $supplier->phone) }}"
            >
        </div>

        <br>

        <div>
            <label for="address">
                Adresse :
            </label>

            <textarea
                id="address"
                name="address"
            >{{ old('address', $supplier->address) }}</textarea>
        </div>

        <br>

        <button type="submit">
            Enregistrer les modifications
        </button>

    </form>

    <br>

    <a href="{{ route('suppliers.show', $supplier) }}">
        Annuler
    </a>

</body>
</html>