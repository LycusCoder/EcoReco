<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LamanDepanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffProductController;
use App\Http\Controllers\StaffOrderController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LamanDepanController::class, 'index'])->name('home');
Route::get('/testimonials', [LamanDepanController::class, 'testimonials'])->name('testimonials');
Route::get('/tentang', [LamanDepanController::class, 'about'])->name('about');
Route::get('/kontak', [LamanDepanController::class, 'contact'])->name('contact');
Route::post('/kontak', [LamanDepanController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/rekomendasi', [LamanDepanController::class, 'recommendations'])->name('recommendations');

// Product and Category routes
Route::prefix('products')->group(function () {
    Route::get('/pencarian', [ProductController::class, 'search'])->name('products.search');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('products.lihat');
});


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{slug}', [CategoryController::class, 'showProductsByCategory'])->name('products.by.category');
});

// Cart routes
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registration routes
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password reset routes
    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.passwords.reset', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', function (Illuminate\Http\Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

    // Checkout routes
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/', [CheckoutController::class, 'process'])->name('checkout.process');
    });

    // Order routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    // Product rating route
    Route::post('/produk/{product}/rate', [ProductController::class, 'rate'])->name('products.rate');
});

// Staff Dashboard routes
Route::middleware(['auth', 'staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');

     // Route untuk ambil data berdasarkan periode
     Route::get('/dashboard/data', [StaffDashboardController::class, 'getData'])
     ->name('staff.dashboard.data');


    // Orders
    Route::get('/orders', [StaffOrderController::class, 'index'])->name('staff.orders');
    Route::put('/orders/{order}/status', [StaffOrderController::class, 'updateStatus'])->name('staff.orders.update.status');
    // Route untuk cetak PDF
    Route::get('/orders/{order}/pdf/preview', [StaffOrderController::class, 'previewPDF'])->name('staff.orders.pdf.preview');
    Route::get('/orders/{order}/pdf/download', [StaffOrderController::class, 'generatePDF'])->name('staff.orders.pdf.download');

    // Preview Invoice (HTML)
    Route::get('/orders/{order}/preview', [StaffOrderController::class, 'previewInvoice'])->name('staff.orders.preview');

    // Produk & Kategori
    Route::resource('products', StaffProductController::class)
    ->except('show')
    ->names([
        'index' => 'staff.products.index',
        'create' => 'staff.products.create',
        'store' => 'staff.products.store',
        'edit' => 'staff.products.edit',
        'update' => 'staff.products.update',
        'destroy' => 'staff.products.destroy'
    ]);
    Route::resource('categories', StaffCategoryController::class)->except('show');
});

/*
|--------------------------------------------------------------------------
| Testing Routes
|--------------------------------------------------------------------------
*/
Route::get('/generate-recommendations', function () {
    $controller = new \App\Http\Controllers\LamanDepanController();
    $controller->generateAprioriRecommendations();
    return "Rekomendasi berhasil di-generate!";
});
