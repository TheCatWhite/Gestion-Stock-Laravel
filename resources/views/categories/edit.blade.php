<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier {{ $category->name }}</title>
</head>
<body>

    <h1>Modifier la catégorie</h1>

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
        action="{{ route('categories.update', $category) }}"
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
                value="{{ old('name', $category->name) }}"
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
            >{{ old('description', $category->description) }}</textarea>
        </div>

        <br>

        <button type="submit">
            Enregistrer les modifications
        </button>

    </form>

    <br>

    <a href="{{ route('categories.show', $category) }}">
        Annuler
    </a>

</body>
</html>