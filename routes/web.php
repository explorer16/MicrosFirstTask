<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/records', function () {
    return Inertia::render('Records/index');
})->middleware(['auth', 'verified'])->name('records');

Route::get('/record_categories', function () {
    return Inertia::render('RecordCategories/index');
})->middleware(['auth', 'verified'])->name('record_categories');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(
    [
        'prefix' => 'api',
        'namespace' => 'App\\Http\\Controllers\\Api\\'
    ], function () {
    Route::apiResource('records', 'RecordController');
    Route::apiResource('record_categories', 'RecordCategoryController');
    Route::get('/record_category/inventory', 'RecordCategoryController@inventory');
    Route::get('dashboard', 'DashboardController@index');
});

require __DIR__.'/auth.php';
