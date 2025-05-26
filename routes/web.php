<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PotensiDesaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\PotensiAreaController;
use App\Http\Controllers\Pengurus\PengurusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VerifikasiPotensiController;


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
    if (auth()->check()) {
        return view('welcome');
    }
    return view('landingPage');
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

Route::get('/category/{category}', [PotensiDesaController::class, 'byCategory'])
    ->name('category.show');

// Admin routes group with auth and role middleware
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Individual kategori routes instead of resource
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/verifikasi-potensi', [App\Http\Controllers\Admin\VerifikasiPotensiController::class, 'index'])->name('verifikasi-potensi');
    Route::get('/potensi-desa/{id}/detail', [App\Http\Controllers\Admin\VerifikasiPotensiController::class, 'show'])
        ->name('potensi-desa.detail');
    Route::patch('/potensi-desa/{id}/reject', [App\Http\Controllers\Admin\VerifikasiPotensiController::class, 'reject'])
        ->name('potensi-desa.reject');

    // Routes untuk verifikasi potensi area
    Route::controller(VerifikasiPotensiController::class)->prefix('potensi-area')->name('potensi-area.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/filter', 'filter')->name('filter');
        Route::get('/pending-count', 'getPendingCount')->name('pending-count');
        Route::get('/{id}', 'show')->name('show');
        Route::patch('/{id}/approve', 'approve')->name('approve');
        Route::patch('/{id}/reject', 'reject')->name('reject');
        Route::post('/bulk-approve', 'bulkApprove')->name('bulk-approve');
    });
    Route::patch('/admin/potensi-area/{id}/approve', [VerifikasiPotensiController::class, 'approve'])->name('admin.potensi-area.approve');
    Route::patch('/admin/potensi-area/{id}/reject', [VerifikasiPotensiController::class, 'reject'])->name('admin.potensi-area.reject');

});

// Pengurus routes group with auth and role middleware
Route::middleware(['auth', 'role:pengurus'])->prefix('pengurus')->group(function () {
    Route::get('/dashboard', [PengurusController::class, 'index'])->name('dashboard');
    Route::post('/potensi-area/{id}/approve', [PotensiAreaController::class, 'approve'])->name('potensi-area.approve');
    Route::post('/potensi-desa/{id}/approve', [PotensiDesaController::class, 'approve'])->name('potensi-desa.approve');
    Route::get('/pengurus/potensi/approval', [PengurusController::class, 'approvalIndex'])->name('potensi.approval');
});

Route::resource('potensi-area', PotensiAreaController::class);
Route::get('/potensi-area/create', [PotensiAreaController::class, 'create'])->name('potensi-area.create');
Route::post('/potensi-area', [PotensiAreaController::class, 'store'])->name('potensi-area.store');

Route::post('/profile/request-role-change', [ProfileController::class, 'requestRoleChange'])->name('profile.requestRoleChange');
Route::post('/admin/approve-role-change/{userId}', [ProfileController::class, 'approveRoleChange'])->name('profile.approveRoleChange');

require __DIR__.'/auth.php';
