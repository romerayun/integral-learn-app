<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTypeController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\FinalQuizController;
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
        return redirect('/my-learning-programs');
    })->name('main');

    Route::get('/my-learning-programs', [LearningProgrammController::class, 'showPersonalLP'])->name('learning-program.my');
    Route::get('/my-learning-programs/{learning_program}', [LearningProgrammController::class, 'showDetailsLP'])->name('learning-program.showDetails');
    Route::get('/my-learning-programs/{learning_program}/{theme}/{activity}', [LearningProgrammController::class, 'showActivity'])->name('learning-program.showActivity');
    Route::post('/my-learning-programs/{learning_program}/{theme}/{activity}/storeQuiz', [LearningProgrammController::class, 'storeQuiz'])->name('learning-program.storeQuiz');
    Route::post('/my-learning-programs/{learning_program}', [LearningProgrammController::class, 'storeTeacher'])->name('learning-program.storeTeacher');
    Route::post('/my-learning-programs/{learning_program}/{theme_id}/{activity_id}', [LearningProgrammController::class, 'completeActivity'])->name('learning_program.complete');
    Route::get('/final-quiz/passing', [FinalQuizController::class, 'getFinalQuiz'])->name('final-quiz.getFinalQuiz');
    Route::post('/final-quiz/passing', [FinalQuizController::class, 'getFinalQuizPost'])->name('final-quiz.getFinalQuizPost');
    Route::get('/final-quiz/passing/{key}', [FinalQuizController::class, 'userQuizPassing'])->name('final-quiz.userPassing');
    Route::post('/final-quiz/passing/{key}', [FinalQuizController::class, 'storeFinalQuiz'])->name('final-quiz.storeFinalQuiz');

    Route::get('/profile-settings', [AuthenticationController::class, 'settings'])->name('user.profile-settings');
    Route::post('/profile-settings/storeAvatar', [AuthenticationController::class, 'storeAvatar'])->name('user.store-avatar');
    Route::post('/profile-settings/storeBanner', [AuthenticationController::class, 'storeBanner'])->name('user.store-banner');

    Route::delete('/profile-settings/destroyAvatar', [AuthenticationController::class, 'destroyAvatar'])->name('user.destroy-avatar');
    Route::delete('/profile-settings/destroyBanner', [AuthenticationController::class, 'destroyBanner'])->name('user.destroy-banner');


    Route::prefix('manage')->middleware('activityLog')->group(function () {
//        Route::resource('/users', UserAdminController::class);
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.index')->middleware('can:all users');
        Route::get('/users/create', [UserAdminController::class, 'create'])->name('users.create')->middleware('can:add users');
        Route::get('/users/import', [ExcelImportController::class, 'importPage'])->name('users.import')->middleware('can:import users');
        Route::post('/users/import', [ExcelImportController::class, 'import'])->name('users.importPost')->middleware('can:import users');
        Route::post('/users', [UserAdminController::class, 'store'])->name('users.store')->middleware('can:add users');
        Route::get('/users/{user}', [UserAdminController::class, 'show'])->name('users.show')->middleware('can:show users');
        Route::get('/users/{user}/edit', [UserAdminController::class, 'edit'])->name('users.edit')->middleware('can:edit users');
        Route::put('/users/{user}', [UserAdminController::class, 'update'])->name('users.update')->middleware('can:edit users');
        Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])->name('users.destroy')->middleware('can:delete users');
        Route::post('/users/repeat/{user}', [UserAdminController::class, 'repeatPassEmail'])->name('users.repeatPE')->middleware('can:repeat password users');



        Route::resource('/groups', GroupController::class)->middleware('can:all groups');
        Route::get('/groups/{group}/add-users', [GroupController::class, 'addUserToGroup'])->name('groups.add-user')->middleware('can:add students group');
        Route::post('/groups/{group}/add-users', [GroupController::class, 'addUserToGroupStore'])->name('groups.add-user-store')->middleware('can:add students group');
        Route::delete('/groups/{group}/add-users/{id}', [GroupController::class, 'destroyGroupUser'])->name('groups.destroy-group-user')->middleware('can:add students group');

        Route::resource('/learning-programs', LearningProgrammController::class)->middleware('can:all lp');

        Route::resource('/activity-types', ActivityTypeController::class)->middleware('can:all activities');

        Route::get('activity-create/{learning_program}', [ActivityController::class, 'createActivity'])->name('activity.createActivity')->middleware('can:show lp');
        Route::get('activity-create/{learning_program}/{theme}', [ActivityController::class, 'createWithTheme'])->name('activity.createWithTheme')->middleware('can:show lp');
        Route::get('activity-create/edit/{activity}', [ActivityController::class, 'edit'])->name('activity.edit')->middleware('can:show lp');
        Route::get('activity-create/{activity}', [ActivityController::class, 'edit'])->name('quiz.construct')->middleware('can:show lp');
        Route::post('/activity-create', [ActivityController::class, 'store'])->name('activity.store')->middleware('can:show lp');
        Route::get('/activities/edit/{activity}', [ActivityController::class, 'edit'])->name('activity.edit')->middleware('can:show lp');
        Route::put('/activities/edit/{activity}', [ActivityController::class, 'update'])->name('activity.update')->middleware('can:show lp');
        Route::get('/activities/quiz/{activity}', [QuizController::class, 'constructQuiz'])->name('quiz.construct')->middleware('can:show lp');


        Route::resource('/final-quiz', FinalQuizController::class)->middleware('can:all final quiz');
        Route::get('/final-quiz/{key}/show', [FinalQuizController::class, 'showResults'])->name('final-quiz.show-results')->middleware('can:show results final quiz');
        Route::get('/final-quiz/{key}/show/{id}', [FinalQuizController::class, 'showAnswers'])->name('final-quiz.show-answers')->middleware('can:show results final quiz');
        Route::put('/final-quiz/disable/{final_quiz}', [FinalQuizController::class, 'disableQuiz'])->name('final-quiz.disable')->middleware('can:close final quiz');

//        Role routes
        Route::resource('/roles', RoleController::class)->middleware('can:all roles');
    });
});


