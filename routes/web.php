<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesController;

/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web de tu aplicación. Estas
| rutas son cargadas por el RouteServiceProvider y todas ellas serán
| asignadas al grupo de middleware "web". ¡Haz algo grandioso!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar la lista de series
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');

// Ruta para mostrar los detalles de una serie específica
Route::get('/series/{id}', [SeriesController::class, 'show'])->name('series.show');
