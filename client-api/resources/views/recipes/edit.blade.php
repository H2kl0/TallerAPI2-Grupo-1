@extends('layouts.index')

@section('title', 'Editar Receta')

@section('content')
    <!-- Header con botón de volver -->
    <div class="recipe-header">
        <a href="{{ route('recipe.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Volver a Recetas
        </a>
    </div>

    <div class="form-container">
        <div class="page-header">
            <h2><i class="fas fa-edit"></i> Editar: {{ $recipe['name'] }}</h2>
        </div>
        <form action="{{ route('recipe.update', $recipe['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre de la Receta</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $recipe['name']) }}">
            </div>
            
            <div class="form-group">
                <label for="cuisine">Tipo de Cocina</label>
                <input type="text" id="cuisine" name="cuisine" value="{{ old('cuisine', $recipe['cuisine']) }}">
            </div>

            <div class="form-group">
                <label for="image">URL de la Imagen</label>
                <input type="url" id="image" name="image" value="{{ old('image', $recipe['image']) }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="prepTimeMinutes">Tiempo Prep. (min)</label>
                    <input type="number" id="prepTimeMinutes" name="prepTimeMinutes" min="0" value="{{ old('prepTimeMinutes', $recipe['prepTimeMinutes']) }}">
                </div>
                <div class="form-group">
                    <label for="cookTimeMinutes">Tiempo Cocción (min)</label>
                    <input type="number" id="cookTimeMinutes" name="cookTimeMinutes" min="0" value="{{ old('cookTimeMinutes', $recipe['cookTimeMinutes']) }}">
                </div>
                <div class="form-group">
                    <label for="servings">Porciones</label>
                    <input type="number" id="servings" name="servings" min="1" value="{{ old('servings', $recipe['servings']) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="caloriesPerServing">Calorías por Porción</label>
                <input type="number" id="caloriesPerServing" name="caloriesPerServing" min="0" value="{{ old('caloriesPerServing', $recipe['caloriesPerServing']) }}">
            </div>

            <div class="form-group">
                <label for="difficulty">Dificultad</label>
                <select id="difficulty" name="difficulty">
                    <option value="Easy" @if(old('difficulty', $recipe['difficulty']) == 'Easy') selected @endif>Fácil</option>
                    <option value="Medium" @if(old('difficulty', $recipe['difficulty']) == 'Medium') selected @endif>Media</option>
                    <option value="Hard" @if(old('difficulty', $recipe['difficulty']) == 'Hard') selected @endif>Difícil</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ingredients">Ingredientes (uno por línea)</label>
                <textarea id="ingredients" name="ingredients" rows="8" required>{{ old('ingredients', implode("\n", $recipe['ingredients'])) }}</textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instrucciones (un paso por línea)</label>
                <textarea id="instructions" name="instructions" rows="10" required>{{ old('instructions', implode("\n", $recipe['instructions'])) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('recipe.show', $recipe['id']) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> Ver Receta
                </a>
                <a href="{{ route('recipe.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection