<?php

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


Route::group(['middleware' => ['web']], function () {
    Route::post('/upload-image', [\App\Http\Controllers\ApiController::class, 'storeImage']);
    Route::post('/store-theme', [\App\Http\Controllers\ThemeController::class, 'store']);
    Route::delete('/destroy-theme/{theme}', [\App\Http\Controllers\ThemeController::class, 'destroy']);
    Route::put('/update-theme/{theme}', [\App\Http\Controllers\ThemeController::class, 'update']);
    Route::put('/update-theme-order/{learning_program}', [\App\Http\Controllers\ThemeController::class, 'updateLocation']);
    Route::delete('/destroy-activity/{activity}', [\App\Http\Controllers\ActivityController::class, 'destroy']);
    Route::put('/update-activity-order/{theme}', [\App\Http\Controllers\ActivityController::class, 'updateLocation']);
    Route::put('/update-double-activity', [\App\Http\Controllers\ActivityController::class, 'updateDoubleActivity']);
    Route::post('/createQuiz/{activity}', [\App\Http\Controllers\QuizController::class, 'createQuiz']);
    Route::delete('/destroy-answer', [\App\Http\Controllers\QuizController::class, 'destroyAnswer']);
    Route::delete('/destroy-question-file', [\App\Http\Controllers\QuizController::class, 'destroyFile']);
    Route::delete('/destroy-question', [\App\Http\Controllers\QuizController::class, 'destroyQuestion']);
    Route::get('/get-activity-log', [\App\Http\Controllers\ApiController::class, 'getActivityByDate']);
//    Route::post('/upload-editor-image', [\App\Http\Controllers\ApiController::class, 'uploadEditorImage']);
    Route::post('/upload-editor-image', [\App\Http\Controllers\ApiController::class, 'upload'])->name('uploadEditorImage');
});
