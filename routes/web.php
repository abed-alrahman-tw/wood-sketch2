<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\BlockedTimeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\BookingController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PortfolioController;
use App\Http\Controllers\Public\ProjectController as PublicProjectController;
use App\Http\Controllers\Public\ServiceController as PublicServiceController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/portfolio', PortfolioController::class)->name('portfolio.index');
Route::get('/portfolio/{slug}', PublicProjectController::class)->name('portfolio.show');
Route::get('/services', [PublicServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [PublicServiceController::class, 'show'])->name('services.show');
Route::get('/about', AboutController::class)->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('admin.dashboard');
        Route::resource('categories', CategoryController::class)
            ->except(['show'])
            ->names('admin.categories');
        Route::resource('services', ServiceController::class)
            ->except(['show'])
            ->names('admin.services');
        Route::resource('projects', ProjectController::class)
            ->except(['show'])
            ->names('admin.projects');
        Route::resource('bookings', AdminBookingController::class)
            ->only(['index', 'show', 'update'])
            ->names('admin.bookings');
        Route::resource('blocked-times', BlockedTimeController::class)
            ->only(['index', 'store', 'destroy'])
            ->names('admin.blocked-times');
    });

require __DIR__.'/auth.php';
