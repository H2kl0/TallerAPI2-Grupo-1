<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra una lista de todas las recetas.
     */
    public function index()
    {
        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $client = Http::acceptJson();
        if ($token = Session::get('token')) {
            $client = $client->withToken($token);
        }

        try {
            $response = $client->get($base);
        } catch (\Throwable $e) {
            $recipes = [];
            return view('recipes.index', [
                'recipes' => $recipes,
                'errorMessage' => 'No se pudo conectar a la API de recetas. Inténtalo de nuevo más tarde.'
            ]);
        }

        if ($response->successful()) {
            $data = $response->json();
            $recipes = $data['recipes'] ?? [];
            return view('recipes.index', compact('recipes'));
        }

        // En caso de error HTTP, mostrar la vista con mensaje en lugar de abortar con 404
        $recipes = [];
        $msg = $response->json()['message'] ?? 'No se pudieron cargar las recetas (HTTP ' . $response->status() . ').';
        return view('recipes.index', [
            'recipes' => $recipes,
            'errorMessage' => $msg,
        ]);
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'cuisine' => 'nullable|string|max:100',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'prepTimeMinutes' => 'nullable|integer|min:0',
            'cookTimeMinutes' => 'nullable|integer|min:0',
            'servings' => 'nullable|integer|min:1',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|url'
        ]);

        // Procesar ingredientes e instrucciones
        $ingredients = array_filter(array_map('trim', explode("\n", $request->ingredients)));
        $instructions = array_filter(array_map('trim', explode("\n", $request->instructions)));

        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $response = Http::acceptJson()->post($base . '/add', [
            'name' => $request->name,
            'ingredients' => $ingredients,
            'instructions' => $instructions,
            'prepTimeMinutes' => (int)$request->prepTimeMinutes ?: 0,
            'cookTimeMinutes' => (int)$request->cookTimeMinutes ?: 0,
            'servings' => (int)$request->servings ?: 1,
            'difficulty' => $request->difficulty,
            'cuisine' => $request->cuisine ?: 'Unknown',
            'caloriesPerServing' => (int)$request->caloriesPerServing ?: 0,
            'image' => $request->image ?: ''
        ]);

        if ($response->successful()) 
        {
            session()->flash('message', 'Receta creada exitosamente');
            return redirect()->route('recipe.index');
        } 
        else 
        {
            return redirect()->route('recipe.create')
                ->withErrors(['error' => 'Error al crear la receta. Inténtalo de nuevo.'])
                ->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $response = Http::acceptJson()->get("https://dummyjson.com/recipes/{$id}");
            
            if ($response->successful()) {
                $recipe = $response->json();
                return view('recipes.show', compact('recipe'));
            } else {
                Log::info("Error al mostrar receta {$id}: Status {$response->status()}");
                return redirect()->route('recipe.index')->withErrors(['message' => "Receta con ID {$id} no encontrada."]);
            }
        } catch (\Exception $e) {
            Log::error("Excepción al mostrar receta {$id}: " . $e->getMessage());
            return redirect()->route('recipe.index')->withErrors(['message' => 'Error de conexión al obtener la receta.']);
        }
    }

    public function edit(string $id)
    {
        try {
            $response = Http::acceptJson()->get("https://dummyjson.com/recipes/{$id}");
            
            if ($response->successful()) {
                $recipe = $response->json();
                return view('recipes.edit', compact('recipe'));
            } else {
                // Log para debugging
                Log::info("Error al obtener receta {$id}: Status {$response->status()}");
                return redirect()->route('recipe.index')->withErrors(['message' => "Receta con ID {$id} no encontrada."]);
            }
        } catch (\Exception $e) {
            Log::error("Excepción al obtener receta {$id}: " . $e->getMessage());
            return redirect()->route('recipe.index')->withErrors(['message' => 'Error de conexión al obtener la receta.']);
        }
    }

    public function update(Request $request, string $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'cuisine' => 'nullable|string|max:100',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'prepTimeMinutes' => 'nullable|integer|min:0',
            'cookTimeMinutes' => 'nullable|integer|min:0',
            'servings' => 'nullable|integer|min:1',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|url'
        ]);

        // Procesar ingredientes e instrucciones (convertir de texto a array)
        $ingredients = array_filter(array_map('trim', explode("\n", $request->ingredients)));
        $instructions = array_filter(array_map('trim', explode("\n", $request->instructions)));

        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $response = Http::acceptJson()->put($base . '/' . $id, [
            'name' => $request->name,
            'ingredients' => $ingredients, 
            'instructions' => $instructions, 
            'prepTimeMinutes' => (int)$request->prepTimeMinutes ?: 0,
            'cookTimeMinutes' => (int)$request->cookTimeMinutes ?: 0,
            'servings' => (int)$request->servings ?: 1,
            'difficulty' => $request->difficulty,
            'cuisine' => $request->cuisine ?: 'Unknown',
            'caloriesPerServing' => (int)$request->caloriesPerServing ?: 0,
            'image' => $request->image ?: ''
        ]);

        if ($response->successful()) 
        {
            session()->flash('message', 'Receta actualizada exitosamente');
            return redirect()->route('recipe.show', $id);
        } 
        else 
        {
            // Para debugging, mostrar el error específico
            $errorMessage = 'Error al actualizar la receta';
            if ($response->status() == 404) {
                $errorMessage = 'Receta no encontrada';
            } elseif ($response->status() >= 400) {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Error en los datos enviados';
            }
            
            return redirect()->route('recipe.edit', $id)
                ->withErrors(['error' => $errorMessage])
                ->withInput();
        }
    }


    public function destroy(string $id)
    {
        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $response = Http::acceptJson()->delete($base . '/' . $id);

        if ($response->successful()) 
        {
            session()->flash('message', 'Receta eliminada exitosamente');
            return redirect()->route('recipe.index');
        } 
        else
        {
            return redirect()->route('recipe.index')->withErrors(['message' => 'No se pudo eliminar la receta. Inténtalo de nuevo.']);
        }
    }
}

