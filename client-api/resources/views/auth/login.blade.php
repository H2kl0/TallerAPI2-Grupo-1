@extends('layouts.auth')

@section('title', 'Iniciar Sesión - Mi Libro de Recetas')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <h1>¡Bienvenido de vuelta!</h1>
            <p>Inicia sesión para acceder a tu colección de recetas deliciosas</p>
        </div>

        <form method="POST" action="{{ route('auth.login') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user label-icon"></i>
                    Nombre de Usuario
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="{{ old('username') }}" 
                    placeholder="emilys"
                    required
                    autocomplete="username"
                >
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock label-icon"></i>
                    Contraseña
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-auth btn-primary">
                <i class="fas fa-sign-in-alt btn-icon"></i>
                Iniciar Sesión
            </button>
        </form>

        <div class="auth-footer">
            <p>Usa las credenciales de prueba: <strong>emilys</strong> / <strong>emilyspass</strong></p>
            <p><small>Más usuarios disponibles en <a href="https://dummyjson.com/users" target="_blank" class="auth-link">dummyjson.com/users</a></small></p>
        </div>
    </div>

    <div class="auth-decoration">
        <div class="floating-food"><i class="fas fa-pizza-slice"></i></div>
        <div class="floating-food"><i class="fas fa-hamburger"></i></div>
        <div class="floating-food"><i class="fas fa-coffee"></i></div>
        <div class="floating-food"><i class="fas fa-ice-cream"></i></div>
        <div class="floating-food"><i class="fas fa-cookie-bite"></i></div>
        <div class="floating-food"><i class="fas fa-apple-alt"></i></div>
    </div>
</div>
@endsection
