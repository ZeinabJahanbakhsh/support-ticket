<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Admin\TicketController;
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


//Label
Route::resource('labels', LabelController::class)->except('edit', 'create');

//Category
Route::resource('categories', CategoryController::class)->except('edit', 'create');

//Priority
Route::resource('priorities', PriorityController::class)->except('edit', 'create');

//Ticket
Route::get('tickets', [TicketController::class, 'index']);
Route::get('tickets/{ticket}', [TicketController::class, 'show']);
Route::post('tickets', [TicketController::class, 'store']);
Route::get('tickets/{ticket}', [TicketController::class, 'getTicketsByStatus']);
