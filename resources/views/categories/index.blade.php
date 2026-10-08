<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catégories</title>
</head>
<body>

    <h1>Liste des catégories</h1>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('categories.create') }}">
        Ajouter une catégorie
    </a>

    <br><br>

    @if($categories->count() > 0)

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>

                        <td>{{ $category->name }}</td>

                        <td>{{ $category->description }}</td>

                        <td>
                            <a href="{{ route('categories.show', $category) }}">
                                Voir
                            </a>

                            |

                            <a href="{{ route('categories.edit', $category) }}">
                                Modifier
                            </a>

                            |

                            <form
                                action="{{ route('categories.destroy', $category) }}"
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

        <p>Aucune catégorie enregistrée.</p>

    @endif

</body>
</html>