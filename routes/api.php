<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'create_user']);


Route::middleware(['auth:sanctum'], function() {
    Route::post('/create_system', [SystemController::class, 'create_system']); 
    Route::post('/list_specific_system', [SystemController::class, 'list_specific_system']);
    Route::post('/update_system', [SystemController::class, 'update_system']);
    Route::post('/delete_system', [SystemController::class, 'delete_system']);
    Route::get('/list_all_sysytems', [SystemController::class, 'list_all_sysytems']);
    Route::post('/leggo', [SystemController::class, 'leggo']);
    Route::post('/logout_me_out', [UserController::class, 'logout']); 
});

