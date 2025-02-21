<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\ShopCheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BlogController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\KuponController;
use App\Http\Controllers\Admin\BlogAdminController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop-detail/{slug}', [ShopDetailController::class, 'index'])->name('shop-detail.index');


Route::get('/blog', [BlogController::class, 'index'])->name('blog-a.index');
Route::get('/blog-detail/{slug}', [BlogController::class, 'detail'])->name('blog-detail.index');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::controller(ShopCartController::class)->group(function () {
    Route::get('/shop-cart', 'index')->name('shop-cart.index');
    Route::post('/cart/store', 'store')->name('cart.store');
    Route::put('/shop-cart/{cartId}', 'update')->name('shop-cart.update');
    Route::delete('/shop-cart/{cartId}', 'destroy')->name('shop-cart.remove');
    Route::post('/shop-cart/clear', 'clear')->name('shop-cart.clear');
});

// Cart dropdown AJAX route
Route::get('/cart/dropdown', [ShopCartController::class, 'getDropdownData'])
    ->name('cart.dropdown');

Route::controller(ShopCheckoutController::class)->group(function () {
    Route::get('/shop-checkout', 'index')->name('shop-checkout.index');
    Route::post('/checkout/process', 'processCheckout')->name('checkout.process');
});

Route::post('/validate-coupon', [ShopCheckoutController::class, 'validateCoupon'])
    ->name('validate.coupon');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login.index');
    Route::post('/login', 'login')->name('login.submit');
    Route::get('/register', 'register')->name('register.index');
    Route::post('/register', 'registerStore')->name('register.store');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/forgot-password', [AccountController::class, 'showForgotPasswordForm'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [AccountController::class, 'sendPasswordResetLink'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [AccountController::class, 'showPasswordResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [AccountController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'sendContactForm'])->name('contact.send');
Route::get('/privacy-policy', [PolicyController::class, 'index'])->name('privacy.index');
Route::get('/terms-policy', [PolicyController::class, 'terms'])->name('terms.index');
Route::get('/refund-policy', [PolicyController::class, 'refund'])->name('refund.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-account', [AccountController::class, 'index'])->name('my-account.index');
    Route::post('/my-account/update-details', [AccountController::class, 'updateAccountDetails'])->name('my-account.update-details');
    Route::post('/my-account/change-password', [AccountController::class, 'changePassword'])->name('my-account.change-password');
    Route::get('/order/{nomer_order}', [AccountController::class, 'orderDetails'])->name('order.details');
});

Route::controller(LoginAdminController::class)->prefix('back-login')->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/', 'postlogin')->name('postlogin');
});

Route::middleware(['admin'])->prefix('back/')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.index');
    });

    Route::resource('kategori', KategoriController::class);

    Route::resource('produk', ProdukController::class);

    Route::resource('pembelian', PembelianController::class);

    Route::post('/pembelian/{id}/konfirmasi', [PembelianController::class, 'konfirmasi'])
        ->name('admin.pembelian.konfirmasi');

    Route::resource('user-admin', UserController::class);
    Route::delete('/user-admin/{id}', [UserController::class, 'destroy'])->name('user-admin.destroy');


    Route::resource('admin', AdminController::class);

    Route::resource('faq', FaqController::class);

    Route::resource('kupon', KuponController::class);

    Route::resource('blog', BlogAdminController::class);

    Route::resource('contact-admin', ContactAdminController::class);

    Route::controller(LaporanController::class)->group(function () {
        Route::get('/laporan-pembelian', 'pembelian')->name('laporan.pembelian');
    });

    Route::controller(LoginAdminController::class)->group(function () {
        Route::get('/logout-admin', 'logout_admin')->name('logoutadmin.index');
    });

});
