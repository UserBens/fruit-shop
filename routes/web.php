<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;

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

Route::get('/', [ShopController::class, 'index']);
Route::get('/single-product/{id}', [ShopController::class, 'singleproduct'])->name('singleproduct');
// routes/web.php

// Route::get('/payment/create/{id}', [ShopController::class, 'createpayment'])->name('create.payment');

Route::post('/payment/create/{id}', [ShopController::class, 'createpayment'])->name('create.payment');

// Route::middleware(['auth', 'user'])->group(function () {
//     Route::get('/', [ShopController::class, 'index'])->name('index');
//     Route::get('/single-product/{id}', [ShopController::class, 'singleproduct'])->name('singleproduct');
//     // Tambahkan rute lainnya sesuai kebutuhan
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
// });
Route::resource('/produk', ProdukController::class)->middleware('verified');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
