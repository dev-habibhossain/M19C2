<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/one-to-one', [TestController::class, 'oneToOne']);
Route::get('/one-to-many', [TestController::class, 'oneToMany']);
Route::get('/many-to-many', [TestController::class, 'manyToMany']);
Route::get('/product-with-cat', [TestController::class, 'productWithCat']);
Route::get('/selfRef', [TestController::class,'selfRef']);

Route::get('/summary', [ReportController::class, 'summary']);