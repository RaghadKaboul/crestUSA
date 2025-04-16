<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\CertificateAPIController;
use App\Http\Controllers\APIs\AuthAPIController;

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

Route::post('/login', [AuthAPIController::class, 'login']);
Route::post('/logout', [AuthAPIController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/refresh-token', [AuthAPIController::class, 'refreshToken'])->middleware('auth:sanctum');
Route::get('/Certificate/index', [CertificateAPIController::class, 'index'])->middleware('auth:sanctum');
Route::put('/Certificate/{id}', [CertificateAPIController::class, 'update'])->middleware('auth:sanctum');
Route::post('/Certificate/store', [CertificateAPIController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/Certificate/{id}', [CertificateAPIController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/Certificate/search', [CertificateAPIController::class, 'search']);




