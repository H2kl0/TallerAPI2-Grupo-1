<?php

use App\Http\Controllers\RecipeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('recipe')->group(function(){
    // Ruta de diagnóstico para verificar que el grupo se carga correctamente
    Route::get('/ping', function () { return 'ok'; });
    Route::get('/index', [RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/create', [RecipeController::class, 'create'])->name('recipe.create');
    Route::get('/edit/{id}', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::post('/store', [RecipeController::class, 'store'])->name('recipe.store');
    Route::get('/show/{id}', [RecipeController::class, 'show'])->name('recipe.show');
    Route::put('/update/{id}', [RecipeController::class, 'update'])->name('recipe.update');
    Route::get('/destroy/{id}', [RecipeController::class, 'destroy'])->name('recipe.destroy');
});


