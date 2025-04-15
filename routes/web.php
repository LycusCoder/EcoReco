<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LamanDepanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryControllers;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// Public routes
Route::get('/', [LamanDepanController::class, 'index'])->name('home');
Route::get('/testimonials', [LamanDepanController::class, 'testimonials'])->name('testimonials');
Route::get('/about', [LamanDepanController::class, 'about'])->name('about');
Route::get('/contact', [LamanDepanController::class, 'contact'])->name('contact');
Route::get('/recommendations', [LamanDepanController::class, 'recommendations'])->name('recommendations');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/contact', [LamanDepanController::class, 'contactSubmit'])->name('contact.submit');
// Search routes
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'showProductsByCategory'])->name('products.by.category');
Route::get('/search', [CategoryController::class, 'search'])->name('products.search');

// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/products/{product}/rate', [ProductController::class, 'rate'])
    ->name('products.rate');
      // Order routes
      Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
      Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Profile routes
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});



//////////testing /////////////
Route::get('/generate-recommendations', function () {
    $controller = new \App\Http\Controllers\LamanDepanController();
    $controller->generateAprioriRecommendations();
    return "Rekomendasi berhasil di-generate!";
});
