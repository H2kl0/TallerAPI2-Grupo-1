@extends('layouts.app')

@section('title', 'Añadir Nueva Receta')

@section('content')
    <div class="form-container">
        <h2>Añadir Nueva Receta.</h2>
        <form action="{{ route('recipe.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre de la Receta</label>
                <input type="text" id="name" name="name" required placeholder="Ej: Pizza Margherita" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="cuisine">Tipo de Cocina</label>
                <input type="text" id="cuisine" name="cuisine" placeholder="Ej: Italiana" value="{{ old('cuisine') }}">
            </div>

            <div class="form-group">
                <label for="image">URL de la Imagen</label>
                <input type="url" id="image" name="image" placeholder="https://ejemplo.com/imagen.jpg" value="{{ old('image') }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="prepTimeMinutes">Tiempo Prep. (min)</label>
                    <input type="number" id="prepTimeMinutes" name="prepTimeMinutes" min="0" value="{{ old('prepTimeMinutes') }}">
                </div>
                <div class="form-group">
                    <label for="cookTimeMinutes">Tiempo Cocción (min)</label>
                    <input type="number" id="cookTimeMinutes" name="cookTimeMinutes" min="0" value="{{ old('cookTimeMinutes') }}">
                </div>
                <div class="form-group">
                    <label for="servings">Porciones</label>
                    <input type="number" id="servings" name="servings" min="1" value="{{ old('servings') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="difficulty">Dificultad</label>
                <select id="difficulty" name="difficulty">
                    <option value="Easy" @if(old('difficulty') == 'Easy') selected @endif>Fácil</option>
                    <option value="Medium" @if(old('difficulty') == 'Medium') selected @endif>Media</option>
                    <option value="Hard" @if(old('difficulty') == 'Hard') selected @endif>Difícil</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ingredients">Ingredientes (uno por línea)</label>
                <textarea id="ingredients" name="ingredients" rows="8" required>{{ old('ingredients') }}</textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instrucciones (un paso por línea)</label>
                <textarea id="instructions" name="instructions" rows="10" required>{{ old('instructions') }}</textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar Receta</button>
                <a href="{{ route('recipe.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection