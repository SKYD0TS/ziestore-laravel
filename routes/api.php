<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
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

Route::get('csrf-token', function () {
    return response()->json(['csrf_token'=>csrf_token()]);
});

Route::post('test', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::post('auth/get-token', [AuthController::class, 'getToken']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum', 'role:cashier|owner']], function () {
    Route::resource('transaction/{type}', TransactionController::class)->parameter('{type}', 'id');
});

Route::group(['middleware' => ['auth:sanctum', 'role:operator|owner']], function () {
    Route::resource('user/{model}', UserController::class)->parameter('{model}', 'id');
});

Route::group(['middleware' => ['auth:sanctum', 'role:cashier|operator|owner']], function () {
    Route::resource('model/{model}', CrudController::class)->parameter('{model}', 'id');
});

// Route::get('/transaction/in/{transaction_code}', [TransactionInController::class, 'show']);
// 
//  Transaction
//  get//: fetch transaction in datas
//  get/{transaction_code}//: fetch correspoding transaction
//  post//: create transaction in data, return transaction_code
//  put/{transaction_code}//: update transaction with data
//  
//  role:owner
//  delete/{transaction_code}//: delete transaction with data
//  
//  transaction/detail
//  get/{transaction_code}// fetch details of transaction
//  post/{transaction_code}//: create transaction detail with data + transaction_code
//  puts/{id}//: update transaction detail with data 
//  delete/{id}//: delete transaction detail
//  
