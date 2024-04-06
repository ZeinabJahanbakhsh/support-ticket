<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\TicketController;
use App\Http\Middleware\AllRolesAccess;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login'])->middleware(['throttle:loginUser']);


//Admin
Route::prefix('admin')->middleware(['auth:sanctum', 'is.admin'])->group(function () {

    //Label
    Route::resource('labels', LabelController::class)->except('edit', 'create');

    //Category
    Route::resource('categories', CategoryController::class)->except('edit', 'create');

    //Priority
    Route::resource('priorities', PriorityController::class)->except('edit', 'create');


    Route::controller(\App\Http\Controllers\Admin\TicketController::class)->prefix('tickets')->group(function () {
            Route::get('/', 'index');
            Route::get('{ticket}', 'show');
            Route::put('/{ticket}', 'update');  //admin, TODO: agent
            Route::get('statuses/{status}', 'getTicketsByStatus');
            Route::get('priorities/{priority}', 'getTicketsByPriority');
            Route::get('categories/{category}', 'getTicketsByCategory');
        });

    }); //  ./admins



//Ticket
Route::prefix('tickets')->middleware(['auth:sanctum'])->group(function () {


    Route::controller(\App\Http\Controllers\User\TicketController::class)
         ->middleware(['agent.default.roles.access'])->group(function () {
            Route::post('users', 'store');  //agent, default

            Route::prefix('users/{user}')->group(function () {
                Route::get('{ticket}', 'show'); //agent, default
                Route::get('/', 'index');       //agent, default
                Route::get('statuses/{status}', 'getTicketsByStatus');
                Route::get('priorities/{priority}', 'getTicketsByPriority');
                Route::get('categories/{category}', 'getTicketsByCategory');
            });

        });//  ./users/{user}


});//  ./tickets

