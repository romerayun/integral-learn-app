<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTypeController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LearningProgrammController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoleController;
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



// Authentication routes

Route::controller(AuthenticationController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'postLogin')->name('post-login');
    Route::get('/registration', 'registration')->name('registration');
    Route::post('/registration', 'storeUser')->name('store-user');
    Route::get('/verify/{token}', 'verifyAccount')->name('user.verify');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/forgot-password', 'forgot')->name('forgot');
//    Route::get('/forgot-password', 'showResetPasswordForm')->name('forgot');
    Route::post('/forgot-password', 'submitForgotPassword')->name('forgot-send');
    Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
    Route::get('/repeat-email', 'repeatEmail')->name('registration.repeatEmail');
    Route::post('/repeat-email', 'repeatEmailPost')->name('registration.repeatEmailPost');
});

// End authentication routes


Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('main');
    })->name('main');

    Route::get('/my-learning-programs', [LearningProgrammController::class, 'showPersonalLP'])->name('learning-program.my');
    Route::get('/my-learning-programs/{learning_program}', [LearningProgrammController::class, 'showDetailsLP'])->name('learning-program.showDetails');


    Route::prefix('manage')->middleware('activityLog')->group(function () {
//        Route::resource('/users', UserAdminController::class);
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.index')->middleware('can:all users');
        Route::get('/users/create', [UserAdminController::class, 'create'])->name('users.create')->middleware('can:add users');
        Route::get('/users/import', [ExcelImportController::class, 'importPage'])->name('users.import');
        Route::post('/users/import', [ExcelImportController::class, 'import'])->name('users.importPost');
        Route::post('/users', [UserAdminController::class, 'store'])->name('users.store')->middleware('can:add users');
        Route::get('/users/{user}', [UserAdminController::class, 'show'])->name('users.show')->middleware('can:show users');
        Route::get('/users/{user}/edit', [UserAdminController::class, 'edit'])->name('users.edit')->middleware('can:edit users');
        Route::put('/users/{user}', [UserAdminController::class, 'update'])->name('users.update')->middleware('can:edit users');
        Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])->name('users.destroy')->middleware('can:delete users');
        Route::post('/users/repeat/{user}', [UserAdminController::class, 'repeatPassEmail'])->name('users.repeatPE');



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


//        Role routes
        Route::resource('/roles', RoleController::class)->middleware('role:super-user');
    });
});


