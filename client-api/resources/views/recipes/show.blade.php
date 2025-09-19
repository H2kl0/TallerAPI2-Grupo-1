@extends('layouts.index')

@section('title', $recipe['name'] ?? 'Detalle de Receta')

@section('content')
    <div class="recipe-detail">
        <h2>{{ $recipe['name'] ?? 'Receta' }}</h2>
        @if (!empty($recipe['image']))
            <img src="{{ $recipe['image'] }}" alt="Imagen de {{ $recipe['name'] }}" style="max-width: 100%; height: auto; border-radius: 8px;"/>
        @endif

        <div class="meta">
            <span class="tag {{ strtolower($recipe['difficulty'] ?? '') }}">{{ $recipe['difficulty'] ?? 'N/A' }}</span>
            <span class="tag cuisine">{{ $recipe['cuisine'] ?? 'N/A' }}</span>
            <span>Prep: {{ $recipe['prepTimeMinutes'] ?? '0' }} min</span>
            <span>Cook: {{ $recipe['cookTimeMinutes'] ?? '0' }} min</span>
            <span>Porciones: {{ $recipe['servings'] ?? '1' }}</span>
        </div>

        @if (!empty($recipe['ingredients']))
            <h3>Ingredientes</h3>
            <ul>
                @foreach ($recipe['ingredients'] as $ing)
                    <li>{{ $ing }}</li>
                @endforeach
            </ul>
        @endif

        @if (!empty($recipe['instructions']))
            <h3>Instrucciones</h3>
            <ol>
                @foreach ($recipe['instructions'] as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ol>
        @endif

        <div class="actions" style="margin-top: 16px; display: flex; gap: 8px;">
            <a href="{{ route('recipe.index') }}" class="btn btn-secondary">Volver</a>
            @if (!empty($recipe['id']))
                <a href="{{ route('recipe.edit', $recipe['id']) }}" class="btn btn-primary">Editar</a>
                <a href="{{ route('recipe.destroy', $recipe['id']) }}" class="btn btn-danger" onclick="return confirm('¿Eliminar esta receta?')">Eliminar</a>
            @endif
        </div>
    </div>
@endsection
