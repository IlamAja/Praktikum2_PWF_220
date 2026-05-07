<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\namaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Test route for documentation
Route::get('/test-docs', function () {
    return response()->json(['message' => 'Test documentation route works']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/api-tester', function () {
    return view('api-tester');
})->name('api-tester');

Route::get('/documentation', function () {
    return redirect('/docs/api');
});

Route::middleware('auth')->group(function () {
    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('kategoris', KategoriController::class);
});

Route::middleware(['auth', 'can:manage-product'])->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/about', [namaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('about');

require __DIR__.'/auth.php';
