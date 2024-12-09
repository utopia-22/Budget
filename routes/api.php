<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProductsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('add-income',[IncomeController::class,'adding']);

Route::post('add-product',[ProductsController::class,'adding']);
Route::put('edit-product',[ProductsController::class,'edit']);
Route::delete('delete-product',[ProductsController::class,'delete']);
Route::get('get-allproduct',[ProductsController::class,'show']);