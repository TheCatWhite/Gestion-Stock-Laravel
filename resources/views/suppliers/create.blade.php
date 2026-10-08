<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un fournisseur</title>
</head>
<body>

    <h1>Ajouter un fournisseur</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('suppliers.store') }}" method="POST">

        @csrf

        <div>
            <label for="name">
                Nom :
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
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
                value="{{ old('email') }}"
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
                value="{{ old('phone') }}"
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
            >{{ old('address') }}</textarea>
        </div>

        <br>

        <button type="submit">
            Ajouter le fournisseur
        </button>

    </form>

    <br>

    <a href="{{ route('suppliers.index') }}">
        Retour aux fournisseurs
    </a>

</body>
</html>