<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuizeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'submit']);
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/quize', [QuizeController::class, 'show']);
    Route::get('/results', [QuizeController::class, 'results']);
    Route::post('/quize/next', [QuizeController::class, 'nextStep']);
    Route::post('/quize/reset', [QuizeController::class, 'reset']);

    Route::group(['middleware' => 'admin'], function() {
        Route::get('/admin/userList', [AdminController::class, 'userList']);
    });

    Route::get('/user', function(Request $request) {
        return $request->user();
    });
});
