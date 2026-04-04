<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/one-to-one', [TestController::class, 'oneToOne']);
Route::get('/one-to-many', [TestController::class, 'oneToMany']);
Route::get('/many-to-many', [TestController::class, 'manyToMany']);