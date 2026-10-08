<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $category->name }}</title>
</head>
<body>

    <h1>Détails de la catégorie</h1>

    <p>
        <strong>ID :</strong>
        {{ $category->id }}
    </p>

    <p>
        <strong>Nom :</strong>
        {{ $category->name }}
    </p>

    <p>
        <strong>Description :</strong>
        {{ $category->description }}
    </p>

    <br>

    <a href="{{ route('categories.edit', $category) }}">
        Modifier
    </a>

    <br><br>

    <a href="{{ route('categories.index') }}">
        Retour à la liste
    </a>

</body>
</html>