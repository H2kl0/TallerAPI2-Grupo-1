@extends('layouts.app')

@section('title', 'Todas las Recetas')

@section('content')
    <div class="page-header">
        <h2>Recetas Populares</h2>
        <a href="{{ route('recipe.create') }}" class="btn btn-primary">Añadir Nueva Receta</a>
    </div>

    <div class="recipe-grid">
        @forelse ($recipes as $recipe)
            <div class="recipe-card">
                <img src="{{ $recipe['image'] }}" alt="Imagen de {{ $recipe['name'] }}">
                <div class="card-content">
                    <h3>{{ $recipe['name'] }}</h3>
                    <div class="card-info">
                        <span class="tag {{ strtolower($recipe['difficulty']) }}">{{ $recipe['difficulty'] }}</span>
                        <span class="tag cuisine">{{ $recipe['cuisine'] }}</span>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('recipe.edit', $recipe['id']) }}" class="btn btn-secondary">Editar</a>
                        <a href="{{ route('recipe.destroy', $recipe['id']) }}" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta receta?')">Eliminar</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No se encontraron recetas para mostrar.</p>
        @endforelse
    </div>
@endsection