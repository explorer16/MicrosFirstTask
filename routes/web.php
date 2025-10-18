<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(
    [
        'prefix' => 'api',
        'namespace' => 'App\\Http\\Controllers\\Api\\'
    ], function () {
        Route::apiResource('records', 'RecordController');
        Route::apiResource('record_categories', 'RecordCategoryController');
    }
);
