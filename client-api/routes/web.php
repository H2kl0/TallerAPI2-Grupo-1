<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to recipes index
Route::get('/', function () {
    return redirect()->route('recipe.index');
})->name('index');

// Authentication routes
Route::prefix('auth')->group(function(){
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Protected recipe routes
Route::middleware(['auth.check'])->prefix('recipe')->group(function(){
    // Ruta de diagnóstico para verificar que el grupo se carga correctamente
    Route::get('/ping', function () { return 'ok'; });
    
    // Ruta de debug para probar la API
    Route::get('/debug/{id}', function ($id) {
        $response = \Illuminate\Support\Facades\Http::acceptJson()->get("https://dummyjson.com/recipes/{$id}");
        return response()->json([
            'status' => $response->status(),
            'successful' => $response->successful(),
            'data' => $response->json(),
            'url' => "https://dummyjson.com/recipes/{$id}"
        ]);
    })->name('recipe.debug');
    
    Route::get('/index', [RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/create', [RecipeController::class, 'create'])->name('recipe.create');
    Route::get('/edit/{id}', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::get('/show/{id}', [RecipeController::class, 'show'])->name('recipe.show');
    Route::post('/store', [RecipeController::class, 'store'])->name('recipe.store');
    Route::put('/update/{id}', [RecipeController::class, 'update'])->name('recipe.update');
    Route::get('/destroy/{id}', [RecipeController::class, 'destroy'])->name('recipe.destroy');
});
