<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeneralController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::get('/store-category', [GeneralController::class, 'storeCategory']);

Route::get('/category-product', [GeneralController::class, 'index']);
Route::get('/product/{slug}', [GeneralController::class, 'getProductBySlug']);
// Route::get('/product/{id}', [GeneralController::class, 'getProduct']);
Route::get('/update-product', [GeneralController::class, 'updateExistingProductInfo']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-email', [GeneralController::class, 'sendEmail']);
