<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/test/{topic}', [TopicController::class, 'show']);



Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
    });

    Route::prefix('topics')->group(function () {
        Route::get('/', [TopicController::class, 'index']);
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', [TopicController::class, 'index']);
    });
});


Route::prefix('v2')->group(function () {
    Route::patch('/auth/updatePassword/user/{user}/password/{password}', [AuthController::class, 'updatePassword']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::patch('/auth/register/user/{user}', [UserController::class, 'update']);
});



Route::prefix('v3')->group(
    function () {
        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('auth/logout', [AuthController::class, 'logout']);


            Route::prefix('csv')->group(function () {
                Route::post('/', [CsvController::class, 'store']);
            });


            Route::prefix('nlps')->group(function () {
                Route::get("/", [UserController::class, "index"]);
                Route::post("/", [UserController::class, "store"]);
                Route::patch("/{user}", [UserController::class, "update"]);
                Route::delete("/{user}", [UserController::class, "destroy"]);
            });
        });
    }
);
