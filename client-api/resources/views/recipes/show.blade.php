@extends('layouts.index')

@section('title', $recipe['name'] ?? 'Detalle de Receta')

@section('content')
    <div class="recipe-detail-container">
        <!-- Header con botón de volver -->
        <div class="recipe-header">
            <a href="{{ route('recipe.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver a Recetas
            </a>
        </div>

        <!-- Información principal de la receta -->
        <div class="recipe-hero">
            <div class="recipe-image-container">
                @if (!empty($recipe['image']))
                    <img src="{{ $recipe['image'] }}" alt="Imagen de {{ $recipe['name'] }}" class="recipe-main-image">
                @else
                    <div class="recipe-no-image">
                        <i class="fas fa-utensils"></i>
                        <p>Sin imagen disponible</p>
                    </div>
                @endif
            </div>
            
            <div class="recipe-info">
                <h1 class="recipe-title">{{ $recipe['name'] ?? 'Receta' }}</h1>
                
                <div class="recipe-meta">
                    <div class="meta-item">
                        <i class="fas fa-signal"></i>
                        <span class="tag {{ strtolower($recipe['difficulty'] ?? '') }}">{{ $recipe['difficulty'] ?? 'N/A' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-globe"></i>
                        <span class="tag cuisine">{{ $recipe['cuisine'] ?? 'N/A' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $recipe['servings'] ?? '1' }} porciones</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-fire"></i>
                        <span>{{ $recipe['caloriesPerServing'] ?? 'N/A' }} cal/porción</span>
                    </div>
                </div>

                <div class="recipe-times">
                    <div class="time-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Preparación</strong>
                            <span>{{ $recipe['prepTimeMinutes'] ?? '0' }} min</span>
                        </div>
                    </div>
                    <div class="time-item">
                        <i class="fas fa-fire-burner"></i>
                        <div>
                            <strong>Cocción</strong>
                            <span>{{ $recipe['cookTimeMinutes'] ?? '0' }} min</span>
                        </div>
                    </div>
                    <div class="time-item">
                        <i class="fas fa-hourglass-half"></i>
                        <div>
                            <strong>Total</strong>
                            <span>{{ ($recipe['prepTimeMinutes'] ?? 0) + ($recipe['cookTimeMinutes'] ?? 0) }} min</span>
                        </div>
                    </div>
                </div>

                @if (!empty($recipe['tags']))
                    <div class="recipe-tags">
                        <h4><i class="fas fa-tags"></i> Etiquetas</h4>
                        <div class="tags-container">
                            @foreach ($recipe['tags'] as $tag)
                                <span class="tag-item">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="recipe-content">
            <div class="recipe-section">
                @if (!empty($recipe['ingredients']))
                    <div class="ingredients-section">
                        <h3><i class="fas fa-list-ul"></i> Ingredientes</h3>
                        <ul class="ingredients-list">
                            @foreach ($recipe['ingredients'] as $ingredient)
                                <li class="ingredient-item">
                                    <i class="fas fa-check-circle"></i>
                                    {{ $ingredient }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($recipe['instructions']))
                    <div class="instructions-section">
                        <h3><i class="fas fa-list-ol"></i> Instrucciones</h3>
                        <ol class="instructions-list">
                            @foreach ($recipe['instructions'] as $index => $instruction)
                                <li class="instruction-item">
                                    <div class="instruction-number">{{ $index + 1 }}</div>
                                    <div class="instruction-text">{{ $instruction }}</div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones -->
        <div class="recipe-actions">
            <a href="{{ route('recipe.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            @if (!empty($recipe['id']))
                <a href="{{ route('recipe.edit', $recipe['id']) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Receta
                </a>
                <a href="{{ route('recipe.destroy', $recipe['id']) }}" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta receta?')">
                    <i class="fas fa-trash"></i> Eliminar
                </a>
            @endif
        </div>
    </div>
@endsection
