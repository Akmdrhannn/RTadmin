<?php

use App\Http\Controllers\Api\HistoryPenghuniController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\PengeluaranController;
use App\Http\Controllers\api\PenghuniController;
use App\Http\Controllers\Api\RumahController;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Support\Facades\Auth; // Menambahkan penggunaan Auth

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/check-auth', function () {
        return response()->json(['valid' => Auth::check()]);
    });

    Route::apiResource('/penghuni', PenghuniController::class);
    Route::apiResource('/rumah', RumahController::class);
    Route::apiResource('/pembayaran', PembayaranController::class);
    Route::apiResource('/pengeluaran', PengeluaranController::class);
    Route::apiResource('/history-penghuni', HistoryPenghuniController::class);
});
