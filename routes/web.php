<?php

use App\Http\Controllers\Admin\LinksController as AdminLinksController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\System\LogEditorController;
use App\Http\Controllers\System\QRCodeController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('saveRegister', [RegisterController::class, 'saveRegister'])->name('saveRegister');

Route::get('/', [MainController::class, 'page']);

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('app')->group(function () {
        Route::get('/', [MainController::class, 'index']);

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('links')->group(function () {
            Route::resources(['data' => LinksController::class]);
            Route::post('cancel/{code}', [LinksController::class, 'cancel']);
            Route::get('qrcode/{code}', [LinksController::class, 'qrcode']);
        });
        Route::prefix('analytics')->group(function () {
            Route::resources(['data' => AnalyticsController::class]);
            Route::get('view/{code}', [AnalyticsController::class, 'view']);
        });

        Route::prefix('admin')->group(function () {
            Route::prefix('links')->group(function () {
                Route::resources(['data' => AdminLinksController::class]);
                Route::post('cancel/{code}', [AdminLinksController::class, 'cancel']);
            });
            Route::prefix('user')->group(function () {
                Route::resources(['data' => UserController::class]);
                Route::post('cancel/{code}', [UserController::class, 'cancel']);
            });
        });


        Route::get('log/{table}/{id?}/{column?}', [LogEditorController::class, 'view']);

        Route::fallback(function () {
            return abort('404');
        });
    });
});
Route::get('/{url}', [MainController::class, 'url']);
Route::get('/qr/{code}', [QRCodeController::class, 'index']);
