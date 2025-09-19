<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $response = Http::acceptJson()->withToken(Session::get('token'))->post($base . '/add', [
            
        ]);

        if ($response->successful()) 
        {
            session()->flash('message', 'Receta creada exitosamente');
            return redirect()->route('recipe.index');
        } 
        elseif ($response->status() == Response::HTTP_BAD_REQUEST) 
        {
            $errors = $response->json()['errors'] ?? ['Error' => 'Los datos enviados no son válidos'];
            return redirect()->route('recipe.create')->withErrors($errors)->withInput();
        } 
        else 
        {
            abort($response->status());
        }
    }

    public function show(string $id)
    {
        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $response = Http::acceptJson()->withToken(Session::get('token'))->get($base . '/' . $id);

        if ($response->successful()) 
        {
            $recipe = $response->json();
            return view('recipes.show', compact('recipe'));
        } 
        else 
        {
            abort($response->status());
        }
    }

    public function edit(string $id)
    {
        $url = env('URL_BASE_API', "https://dummyjson.com");
        $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/recipes/' . $id);

        if ($response->successful())
        {
            $recipe = $response->json();
            return view('recipes.edit', compact('recipe'));
        } 
        elseif
            ($response->status() == Response::HTTP_NOT_FOUND)
        {
            return redirect()->route('recipe.index')->withErrors(['message' => 'Receta no encontrada.']);
        } 
        else 
        {
            abort($response->status());
        }
    }

    public function update(Request $request, string $id)
    {
        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $response = Http::acceptJson()->withToken(Session::get('token'))->put($base . '/' . $id, [
            'name' => $request->name,
            'ingredients' => $request->ingredients, 
            'instructions' => $request->instructions, 
            'prepTimeMinutes' => $request->prepTimeMinutes,
            'cookTimeMinutes' => $request->cookTimeMinutes,
            'servings' => $request->servings,
            'difficulty' => $request->difficulty,
            'cuisine' => $request->cuisine,
            'caloriesPerServing' => $request->caloriesPerServing,
            'tags' => $request->tags, 
            'image' => $request->image
            
        ]);

        if ($response->successful()) 
        {
            session()->flash('message', 'Receta actualizada exitosamente');
            return redirect()->route('recipe.index');
        } 
        elseif
         ($response->status() == Response::HTTP_BAD_REQUEST) 
        {
            $errors = $response->json()['errors'] ?? ['Error' => 'Los datos enviados no son válidos'];
            return redirect()->route('recipe.edit', $id)->withErrors($errors)->withInput();
        } 
        else
     {
            abort($response->status());
        }
    }


    public function destroy(string $id)
    {
        $base = rtrim(env('URL_BASE_API', 'https://dummyjson.com/recipes'), '/');
        $response = Http::acceptJson()->withToken(Session::get('token'))->delete($base . '/' . $id);

        if ($response->successful()) 
        {
            session()->flash('message', 'Receta eliminada exitosamente');
            return redirect()->route('recipe.index');
        } 
        else
        {
            $errors = $response->json()['errors'] ?? ['message' => 'No se pudo eliminar la receta. Inténtalo de nuevo.'];
            return redirect()->route('recipe.index')->withErrors($errors);
        }
    }
}

