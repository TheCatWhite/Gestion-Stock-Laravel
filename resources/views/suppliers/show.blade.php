<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $supplier->name }}</title>
</head>
<body>

    <h1>Détails du fournisseur</h1>

    <p>
        <strong>ID :</strong>
        {{ $supplier->id }}
    </p>

    <p>
        <strong>Nom :</strong>
        {{ $supplier->name }}
    </p>

    <p>
        <strong>Email :</strong>
        {{ $supplier->email }}
    </p>

    <p>
        <strong>Téléphone :</strong>
        {{ $supplier->phone }}
    </p>

    <p>
        <strong>Adresse :</strong>
        {{ $supplier->address }}
    </p>

    <br>

    <a href="{{ route('suppliers.edit', $supplier) }}">
        Modifier
    </a>

    <br><br>

    <a href="{{ route('suppliers.index') }}">
        Retour à la liste
    </a>

</body>
</html>