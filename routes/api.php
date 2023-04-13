<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\BarberApiController;
use App\Http\Controllers\TransApiController;

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

Route::post('/login', [UserApiController::class, 'login']);

Route::get('/test', function() {
    return ['test' => 'Ebik'];
});

Route::get('/barberman', [BarberApiController::class, 'index']);
Route::get('/transaction/today', [TransApiCOntroller::class, 'today']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UserApiController::class, 'index']);

    Route::post('/logout', [UserApiController::class, 'logout']);
});
