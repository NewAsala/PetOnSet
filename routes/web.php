<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     return view('test');
// });

Route::get('/', function () {
    return redirect()->route('dashboard', [
        'locale' => session('locale', config('app.locale')),
    ]);
});

Route::prefix('{locale}')
    ->whereIn('locale', array_keys(config('localization.locales')))
    ->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::resource('/customer', CustomerController::class);
            Route::resource('/product', ProductController::class);
            Route::post('/product/import', [ProductController::class, 'import'])->name('product.import');
            Route::resource('/purchase', PurchaseController::class);

            Route::resource('/sale', SaleController::class);
            Route::get('/sales/products/search', [SaleController::class, 'searchProducts'])
                ->name('sale.products.search');

            Route::resource('/user', UserController::class)->except(['show']);
            Route::resource('/supplier', SupplierController::class);
            Route::resource('brand', BrandController::class)->except(['create', 'edit','show']);
            Route::resource('category', CategoryController::class)->except(['create', 'edit','show']);
            Route::resource('pet', PetController::class)->except(['show']);

            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        require __DIR__.'/auth.php';
});
