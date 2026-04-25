<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

// ── Public routes ──────────────────────────────────────────────
Route::get('/', [ProductController::class, 'index'])->name('home');

// Cart
Route::get('/carrito', [OrderController::class, 'cart'])->name('cart');
Route::post('/carrito/agregar', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/carrito/eliminar', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/carrito/pedido', [OrderController::class, 'store'])->name('order.store');
Route::get('/confirmacion/{order}', [OrderController::class, 'confirmation'])->name('confirmation');
Route::post('/carrito/update', [OrderController::class, 'update'])->name('cart.update');
// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Authenticated routes ────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard (pending orders)
    Route::get('/inicio', [OrderController::class, 'dashboard'])->name('dashboard');
    Route::post('/pedido/{order}/estado', [OrderController::class, 'toggleStatus'])->name('order.status');

    // History
    Route::get('/historial', [OrderController::class, 'history'])->name('history');

    // Wallet
    Route::get('/cartera', [OrderController::class, 'wallet'])->name('wallet');

    // Administration
    Route::get('/administracion', function () {
        return view('admin.index');
    })->name('admin');

    // Products admin
    Route::get('/administracion/productos', [ProductController::class, 'adminIndex'])->name('admin.products');
    Route::get('/administracion/productos/crear', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/administracion/productos', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/administracion/productos/{product}/editar', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/administracion/productos/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::patch('/administracion/productos/{product}/estado', [ProductController::class, 'toggleEnabled'])->name('admin.products.toggle');

    // Categories admin (handled within product views)
    Route::post('/administracion/categorias', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/administracion/categorias/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Ingredients admin
    Route::get('/administracion/ingredientes', [IngredientController::class, 'index'])->name('admin.ingredients');
    Route::get('/administracion/ingredientes/crear', [IngredientController::class, 'create'])->name('admin.ingredients.create');
    Route::post('/administracion/ingredientes', [IngredientController::class, 'store'])->name('admin.ingredients.store');
    Route::delete('/administracion/ingredientes/{ingredient}', [IngredientController::class, 'destroy'])->name('admin.ingredients.destroy');

    // Profile
    Route::get('/cuenta', [UserController::class, 'profile'])->name('profile');
    Route::post('/cuenta/perfil', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/cuenta/contrasena', [UserController::class, 'updatePassword'])->name('profile.password');
});
