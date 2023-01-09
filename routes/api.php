<?php

use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\CardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/refresh-token', [\App\Http\Controllers\Api\ApiTokenController::class, 'update'])->name('refresh-token');

    // Columns CRUD
    Route::get('/lists', [\App\Http\Controllers\Api\ColumnController::class, 'index'])->name('lists.index');
    Route::post('/lists', [\App\Http\Controllers\Api\ColumnController::class, 'store'])->name('lists.store');
    Route::post('/lists/{id}', [\App\Http\Controllers\Api\ColumnController::class, 'update'])->name('lists.update');
    Route::post('/lists/delete/{id}', [\App\Http\Controllers\Api\ColumnController::class, 'destroy'])->name('lists.update');

    // Cards CRUD
    Route::get('/list-cards', [\App\Http\Controllers\Api\CardController::class, 'listCards'])->name('cards.listCards');
    Route::get('/cards', [\App\Http\Controllers\Api\CardController::class, 'index'])->name('cards.index');
    Route::post('/cards', [\App\Http\Controllers\Api\CardController::class, 'store'])->name('cards.store');
    Route::post('/cards/{id}', [\App\Http\Controllers\Api\CardController::class, 'update'])->name('cards.update');
    Route::post('/cards/delete/{id}', [\App\Http\Controllers\Api\CardController::class, 'destroy'])->name('cards.update');

//    Route::resources([
//        'lists' => ColumnController::class,
//        'cards' => CardController::class,
//    ]);
});
