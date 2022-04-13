<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\NlpController;
use App\Http\Controllers\QuestionController;
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





Route::prefix('v1')->group(function () {
    Route::prefix('topics')->group(function () {
        Route::get('/', [TopicController::class, 'index']);
    });
});


Route::prefix('v2')->group(function () {
    Route::patch('/auth/updatePassword/user/{user}/password/{password}', [AuthController::class, 'updatePassword']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});



Route::prefix('v3')->group(
    function () {
        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('auth/logout', [AuthController::class, 'logout']);


            Route::prefix('csv')->group(function () {
                Route::post('/', [CsvController::class, 'store']);
            });

            Route::prefix('nlp')->group(function () {
                Route::get('/', [NlpController::class, 'index']);
            });

            Route::prefix('topics')->group(function () {
                Route::get('/', [TopicController::class, 'index'])->name('getAllTopics');
                Route::get('/{topic}', [TopicController::class, 'show']);
                Route::post('/', [TopicController::class, 'store']);
                Route::post('/{parent}', [TopicController::class, 'storeWithParent']);
                Route::patch('/{topic}', [TopicController::class, 'update']);
                Route::delete('/{topic}', [TopicController::class, 'destroy']);
            });

            Route::prefix('questions')->group(function () {
                Route::get('/', [QuestionController::class, 'index']);
                Route::post('/', [QuestionController::class, 'store']);
                Route::patch('/', [QuestionController::class, 'update']);
            });


            Route::prefix('users')->group(function () {
                Route::get("/", [UserController::class, "index"]);
                Route::get("/{user}", [UserController::class, "show"]);
                Route::post("/", [UserController::class, "store"]);
                Route::patch("/{user}", [UserController::class, "update"]);
                Route::delete("/{user}", [UserController::class, "destroy"]);
            });
        });
    }
);
