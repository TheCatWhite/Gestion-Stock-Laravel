<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une catégorie</title>
</head>
<body>

    <h1>Ajouter une catégorie</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">

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
            <label for="description">
                Description :
            </label>

            <textarea
                id="description"
                name="description"
            >{{ old('description') }}</textarea>
        </div>

        <br>

        <button type="submit">
            Ajouter
        </button>

    </form>

    <br>

    <a href="{{ route('categories.index') }}">
        Retour aux catégories
    </a>

</body>
</html>