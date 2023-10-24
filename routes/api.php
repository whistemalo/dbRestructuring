<?php

use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\RequestController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pending-requests', [RequestController::class, 'getPendingRequests']);



Route::get('/pending-requests/{id_request}', [RequestController::class, 'getPendingRequestById']);
Route::post('/change-request-status', [RequestController::class, 'changeRequestStatus']);





Route::get('/get-request/{id_request}', [RequestController::class, 'getRequestTrazability']);





Route::get('/offer/{id_request}', [RequestController::class, 'getRequestTrazability']);


Route::apiResource('v1/employees', EmployeeController::class);


