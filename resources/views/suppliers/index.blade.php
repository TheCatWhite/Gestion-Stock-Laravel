<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fournisseurs</title>
</head>
<body>

    <h1>Liste des fournisseurs</h1>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('suppliers.create') }}">
        Ajouter un fournisseur
    </a>

    <br><br>

    @if($suppliers->count() > 0)

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>

                        <td>{{ $supplier->name }}</td>

                        <td>{{ $supplier->email }}</td>

                        <td>{{ $supplier->phone }}</td>

                        <td>{{ $supplier->address }}</td>

                        <td>
                            <a href="{{ route('suppliers.show', $supplier) }}">
                                Voir
                            </a>

                            |

                            <a href="{{ route('suppliers.edit', $supplier) }}">
                                Modifier
                            </a>

                            |

                            <form
                                action="{{ route('suppliers.destroy', $supplier) }}"
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

        <p>Aucun fournisseur enregistré.</p>

    @endif

</body>
</html>