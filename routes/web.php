<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController as PublicOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

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

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services/{service}', [PageController::class, 'showService'])->name('services.show_public');
Route::get('/order/{service}', [PublicOrderController::class, 'create'])->name('orders.create');
Route::post('/order', [PublicOrderController::class, 'store'])->middleware('throttle:5,1')->name('orders.store');
Route::get('/orders/{order:tracking_code}/receipt', [PublicOrderController::class, 'receipt'])->name('orders.receipt');
Route::get('/track', [PageController::class, 'trackOrder'])->middleware('throttle:30,1')->name('track.show');
Route::post('/track/{order:tracking_code}/review', [ReviewController::class, 'store'])->middleware('throttle:5,1')->name('reviews.store');
Route::get('/services', [PageController::class, 'showAllServices'])->name('services.index_public');
Route::get('/kontak-kami', [PageController::class, 'showContactPage'])->name('contact.show');

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('services', ServiceController::class)->except(['create', 'show']);
    Route::get('orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'update', 'destroy']);
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';
