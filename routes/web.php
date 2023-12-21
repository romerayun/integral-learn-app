<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTypeController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LearningProgrammController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('main');
})->name('main');


// Authentication routes

Route::controller(AuthenticationController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::get('/registration', 'registration')->name('registration');
    Route::post('/registration', 'storeUser')->name('store-user');
});

// End authentication routes


Route::prefix('manage')->group(function () {
    Route::resource('/users', UserAdminController::class);
    Route::resource('/groups', GroupController::class);
    Route::get('/groups/{group}/add-users', [GroupController::class, 'addUserToGroup'])->name('groups.add-user');
    Route::post('/groups/{group}/add-users', [GroupController::class, 'addUserToGroupStore'])->name('groups.add-user-store');
    Route::delete('/groups/{group}/add-users/{id}', [GroupController::class, 'destroyGroupUser'])->name('groups.destroy-group-user');
    Route::resource('/learning-programs', LearningProgrammController::class);
    Route::resource('/activity-types', ActivityTypeController::class);

    Route::get('activity-create/{learning_program}', [ActivityController::class, 'createActivity'])->name('activity.createActivity');
    Route::get('activity-create/{learning_program}/{theme}', [ActivityController::class, 'createWithTheme'])->name('activity.createWithTheme');
    Route::get('activity-create/edit/{activity}', [ActivityController::class, 'edit'])->name('activity.edit');
    Route::get('activity-create/{activity}', [ActivityController::class, 'edit'])->name('quiz.construct');

    Route::post('/activity-create', [ActivityController::class, 'store'])->name('activity.store');
    Route::get('/activities/edit/{activity}', [ActivityController::class, 'edit'])->name('activity.edit');
    Route::put('/activities/edit/{activity}', [ActivityController::class, 'update'])->name('activity.update');

    Route::get('/activities/quiz/{activity}', [QuizController::class, 'constructQuiz'])->name('quiz.construct');
});
