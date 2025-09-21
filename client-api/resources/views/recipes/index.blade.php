@extends('layouts.index')

@section('title', 'Todas las Recetas')

@section('content')
    <div class="page-header">
        <h2><i class="fas fa-utensils"></i> Recetas Populares</h2>
        <a href="{{ route('recipe.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Añadir Nueva Receta
        </a>
    </div>

    <div class="recipe-grid">
        @forelse ($recipes as $recipe)
            <div class="recipe-card">
                <img src="{{ $recipe['image'] }}" alt="Imagen de {{ $recipe['name'] }}">
                <div class="card-content">
                    <h3>{{ $recipe['name'] }}</h3>
                    <div class="card-info">
                        <span class="tag {{ strtolower($recipe['difficulty']) }}">
                            <i class="fas fa-signal"></i> {{ $recipe['difficulty'] }}
                        </span>
                        <span class="tag cuisine">
                            <i class="fas fa-globe"></i> {{ $recipe['cuisine'] }}
                        </span>
                        <span class="tag time">
                            <i class="fas fa-clock"></i> {{ $recipe['prepTimeMinutes'] + $recipe['cookTimeMinutes'] }} min
                        </span>
                    </div>
                    <div class="card-meta">
                        <small class="card-servings">
                            <i class="fas fa-users"></i> {{ $recipe['servings'] }} porciones
                        </small>
                        <small class="card-calories">
                            <i class="fas fa-fire"></i> {{ $recipe['caloriesPerServing'] }} cal/porción
                        </small>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('recipe.show', $recipe['id']) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Ver más
                        </a>
                        <a href="{{ route('recipe.edit', $recipe['id']) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('recipe.destroy', $recipe['id']) }}" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta receta?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>No se encontraron recetas para mostrar.</p>
        @endforelse
    </div>
@endsection