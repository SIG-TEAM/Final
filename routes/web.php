<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PotensiDesaController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('potensidesa', App\Http\Controllers\PotensiDesaController::class);
Route::get('/potensi-desa', [PotensiDesaController::class, 'index'])->name('potensi-desa.index');
Route::get('/potensi-desa/create', [PotensiDesaController::class, 'create'])->name('potensi-desa.create');
Route::post('/potensi-desa', [PotensiDesaController::class, 'store'])->name('potensi-desa.store');
Route::get('/potensi-desa/{id}', [PotensiDesaController::class, 'show'])->name('potensi-desa.show');
Route::get('/potensi-desa/{id}/edit', [PotensiDesaController::class, 'edit'])->name('potensi-desa.edit');
Route::put('/potensi-desa/{id}', [PotensiDesaController::class, 'update'])->name('potensi-desa.update');
Route::delete('/potensi-desa/{id}', [PotensiDesaController::class, 'destroy'])->name('potensi-desa.destroy');

Route::get('/peta-potensi-desa', [PotensiDesaController::class, 'map'])->name('potensi-desa.map');
Route::get('/api/potensi-desa', [PotensiDesaController::class, 'getPotensiData'])->name('api.potensi-desa');

require __DIR__.'/auth.php';
