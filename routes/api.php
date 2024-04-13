<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\CommentController;
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

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login'])->middleware(['throttle:loginUser']);


//Admin
Route::put('admin/tickets/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'update'])
     ->middleware(['auth:sanctum', 'admin.agent.roles.access']);  //admin, agent


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
        Route::get('statuses/{status}', 'getTicketsByStatus');
        Route::get('priorities/{priority}', 'getTicketsByPriority');
        Route::get('categories/{category}', 'getTicketsByCategory');
        Route::post('{ticket}/change-status', 'changeStatus');
    });


    Route::resource('users', UserController::class)->except('edit', 'create');


}); //  ./admin


//Ticket
Route::prefix('users/{user}/tickets')->middleware(['auth:sanctum', 'agent.default.roles.access'])
     ->controller(\App\Http\Controllers\User\TicketController::class)
     ->group(function () {
         Route::post('', 'store');  //agent, default

         Route::get('{ticket}', 'show'); //agent, default //show its comments
         Route::get('/', 'index');       //agent, default  TODO: be check again!
         Route::get('statuses/{status}', 'getTicketsByStatus');
         Route::get('priorities/{priority}', 'getTicketsByPriority');
         Route::get('categories/{category}', 'getTicketsByCategory');

     });//  ./users/{user}/tickets/{ticket}


Route::prefix('users/{user}/comments')->middleware(['auth:sanctum', 'all.roles.access'])
     ->group(function () {

         Route::controller(CommentController::class)->group(function () {
             Route::post('/tickets/{ticket}', 'store');//this user want to send cm for this ticket
             Route::get('{comment}', 'show'); //this user want to see this cm

             Route::get('/tickets/{ticket}/all-comments', 'allCommentsByTicketId'); //all comments of this ticket_id

         });

         /*Route::controller(TicketController::class)
              ->group(function () {
                  Route::get('/all-comments', 'allCommentsByTicketId'); //this user see all its own comments
              });*/

     });
