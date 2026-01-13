<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

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
    });

require __DIR__.'/auth.php';
