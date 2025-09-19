<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Libro de Recetas')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="container">
            <h1><a href="{{ route('recipe.index') }}">Mi Libro de Recetas </a></h1>
            <nav>
                <a href="{{ route('recipe.index') }}" class="{{ request()->routeIs('recipe.index') ? 'active' : '' }}">Inicio</a>
                <a href="{{ route('recipe.create') }}" class="{{ request()->routeIs('recipe.create') ? 'active' : '' }}">Añadir Receta</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>