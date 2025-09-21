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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="container">
            <h1><a href="{{ route('recipe.index') }}"><i class="fas fa-utensils"></i> Mi Libro de Recetas</a></h1>
            <nav>
                <a href="{{ route('recipe.index') }}" class="{{ request()->routeIs('recipe.index') ? 'active' : '' }}">
                    <i class="fas fa-home nav-icon"></i>
                    Inicio
                </a>
                <a href="{{ route('recipe.create') }}" class="{{ request()->routeIs('recipe.create') ? 'active' : '' }}">
                    <i class="fas fa-plus nav-icon"></i>
                    Añadir Receta
                </a>
                @if(Session::has('token'))
                    <div class="user-menu">
                        <span class="user-greeting">
                            <i class="fas fa-user-chef nav-icon"></i>
                            ¡Hola, {{ Session::get('user')->firstName ?? 'Chef' }}!
                        </span>
                        <form method="POST" action="{{ route('auth.logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="fas fa-sign-out-alt nav-icon"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('auth.index') }}" class="btn-login">
                        <i class="fas fa-sign-in-alt nav-icon"></i>
                        Iniciar Sesión
                    </a>
                @endif
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