<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PelatihanKategoriController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentQuizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::redirect('/', '/login');

// Dashboard
Route::get('/home', function () {
    return view('pages.dashboard', ['type_menu' => 'dashboard']);
});
Route::get('/dashboard-ecommerce-dashboard', function () {
    return view('pages.dashboard-ecommerce-dashboard', ['type_menu' => 'dashboard']);
});

// Login 

Route::get('/', [LoginController::class, 'index_student'])->name('login-student');
Route::get('/login-teacher', [LoginController::class, 'index_teacher'])->name('login-teacher');
Route::get('/logout-action', [LoginController::class, 'logout_action']);

Route::get('/forgot-password', [UserController::class, 'forgot']);
Route::post('/forgot-password-action', [UserController::class, 'forgot_action']);
Route::post('/reset-password-action', [UserController::class, 'reset_action']);



Route::post('/login-action', [LoginController::class, 'login_action']);

// Murid
Route::middleware(['authMurid'])->prefix('student')->group(function () {
    // Route::get('/home', function () {
    //     return view('pages.dashboard', ['type_menu' => 'dashboard']);
    // })->name('home-murid');

    // Route::get('/materi', function () {
    //     return view('pages.materi', ['type_menu' => 'components']);
    // });
    Route::get('/home', [DashboardController::class, 'indexDashboardMurid']);
    // Route::get('/materi', [MateriController::class, 'indexMateriMurid']);
    // Route::get('/detail-materi/{id}', [MateriController::class, 'detailMateri']);
    // Route::post('/materi/log-end-time', [MateriController::class, 'logEndTime'])->name('materi.logEndTime');
    Route::get('/notification', [NotificationController::class, 'index']);

    // Quiz

    Route::get('quizzes', [StudentQuizController::class, 'index']);

    Route::get('quizzes/{id}', [StudentQuizController::class, 'showQuiz'])->name('student.quizzes.show');
    Route::post('quizzes/{id}', [StudentQuizController::class, 'submitQuiz'])->name('student.quizzes.submit');
    Route::get('quizzes/{id}/result/{attempt_id}', [StudentQuizController::class, 'showResult'])->name('student.quizzes.result');
    Route::get('quizzes/{user_id}/score/{quiz_id}', [StudentQuizController::class, 'showResultByUser'])->name('student.quizzes.resultByUser');


    Route::get('assignment', [AssignmentController::class, 'indexAssignmentMurid']);
    Route::get('assignment/submission/{id}', [AssignmentController::class, 'edit']);
    Route::post('assignment/submission/{id}/submit', [AssignmentController::class, 'submitSubmission'])->name('student.submission-assignment');
});

Route::middleware(['authGuru'])->prefix('teacher')->group(function () {
    Route::get('/home', [DashboardController::class, 'indexDashboardGuru']);


    // Route::get('/materi', [MateriController::class, 'index']);
    // Route::resource('/materi', MateriController::class);
    // Route::get('/add-materi', [MateriController::class, 'create'])->name("add-materi");
    Route::get('/notification', [NotificationController::class, 'index']);

    Route::resource('/periode', PeriodeController::class);
    Route::get('/add-periode', [PeriodeController::class, 'create'])->name("add-periode");
    // Quiz
    // Route::resource('quizzes', QuizController::class);
    // Route::get('quizzes/edit/{id}', [QuizController::class, 'edit']);
    // Route::put('quizzes/update/{id}', [QuizController::class, 'update']);
    // Route::get('quizzes/{quiz}/questions/create', [QuizController::class, 'createQuestion'])->name('questions.create');
    // Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('questions.store');
    // Route::get('quizzes/{quiz}/questions/{question}/edit', [QuizController::class, 'editQuestion'])->name('questions.edit');
    // Route::put('quizzes/{quiz}/questions/{question}', [QuizController::class, 'updateQuestion'])->name('questions.update');
    // Route::delete('quizzes/{quiz}/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('questions.destroy');

    Route::resource('/manage-student', StudentController::class);
    Route::get('/add-student', [StudentController::class, 'create'])->name("add-student");

    Route::get('quiz', [StudentQuizController::class, 'index']);
    Route::get('quiz/score/{quiz_id}', [StudentQuizController::class, 'showAllResultByGuru'])->name('teacher.quizzes.showAllResultByGuru');



    Route::get('profile', [UserController::class, 'index']);
    Route::put('profile', [UserController::class, 'update']);



    // Route::post('/store-materi', [MateriController::class, 'store']);
});


Route::middleware(['authAdmin'])->prefix('admin')->group(function () {
    Route::get('/home', [DashboardController::class, 'indexDashboardAdmin']);


    // Route::get('/materi', [MateriController::class, 'index']);
    Route::resource('/periode', PeriodeController::class);
    Route::get('/add-periode', [PeriodeController::class, 'create'])->name("add-periode");

    Route::resource('/kategori-pelatihan', PelatihanKategoriController::class);
    Route::get('/add-kategori-pelatihan', [PelatihanKategoriController::class, 'create'])->name("add-kategori-pelatihan");
    Route::get('/notification', [NotificationController::class, 'index']);

    // Quiz
    Route::resource('quizzes', QuizController::class);
    Route::get('quizzes/edit/{id}', [QuizController::class, 'edit']);
    Route::put('quizzes/update/{id}', [QuizController::class, 'update']);
    Route::get('quizzes/{quiz}/questions/create', [QuizController::class, 'createQuestion'])->name('questions.create');
    Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('questions.store');
    Route::get('quizzes/{quiz}/questions/{question}/edit', [QuizController::class, 'editQuestion'])->name('questions.edit');
    Route::put('quizzes/{quiz}/questions/{question}', [QuizController::class, 'updateQuestion'])->name('questions.update');
    Route::delete('quizzes/{quiz}/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('questions.destroy');

    Route::resource('/manage-student', StudentController::class);
    Route::get('/add-student', [StudentController::class, 'create'])->name("add-student");

    Route::resource('/manage-guru', GuruController::class);
    Route::get('/add-guru', [GuruController::class, 'create'])->name("add-guru");

    Route::get('quiz', [StudentQuizController::class, 'index']);
    Route::get('quiz/score/{quiz_id}', [StudentQuizController::class, 'showAllResultByAdmin'])
        ->name('admin.quizzes.showAllResultByAdmin');
    Route::get('/quizzes/{quizzes_id}/export', [StudentQuizController::class, 'exportToExcel'])->name('quizzes.export');

    // Route::get('quiz/score/{quiz_id}', [StudentQuizController::class, 'showAllResultByAdmin'])->name('admin.quizzes.showAllResultebByAdmin');

    Route::resource('assignment', AssignmentController::class);
    Route::get('/add-assignment', [AssignmentController::class, 'create'])->name("add-assignment");
    Route::get('assignments/submission/', [AssignmentController::class, 'indexAssignmentMurid']);
    Route::get('assignments/submission/{id}', [AssignmentController::class, 'viewSubmissions']);

    Route::get('profile', [UserController::class, 'index']);
    Route::put('profile', [UserController::class, 'update']);



    // Route::post('/store-materi', [MateriController::class, 'store']);
});

// Layout
Route::get('/layout-default-layout', function () {
    return view('pages.layout-default-layout', ['type_menu' => 'layout']);
});

// Blank Page
Route::get('/blank-page', function () {
    return view('pages.blank-page', ['type_menu' => '']);
});

// Bootstrap
Route::get('/bootstrap-alert', function () {
    return view('pages.bootstrap-alert', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-badge', function () {
    return view('pages.bootstrap-badge', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-breadcrumb', function () {
    return view('pages.bootstrap-breadcrumb', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-buttons', function () {
    return view('pages.bootstrap-buttons', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-card', function () {
    return view('pages.bootstrap-card', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-carousel', function () {
    return view('pages.bootstrap-carousel', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-collapse', function () {
    return view('pages.bootstrap-collapse', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-dropdown', function () {
    return view('pages.bootstrap-dropdown', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-form', function () {
    return view('pages.bootstrap-form', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-list-group', function () {
    return view('pages.bootstrap-list-group', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-media-object', function () {
    return view('pages.bootstrap-media-object', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-modal', function () {
    return view('pages.bootstrap-modal', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-nav', function () {
    return view('pages.bootstrap-nav', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-navbar', function () {
    return view('pages.bootstrap-navbar', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-pagination', function () {
    return view('pages.bootstrap-pagination', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-popover', function () {
    return view('pages.bootstrap-popover', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-progress', function () {
    return view('pages.bootstrap-progress', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-table', function () {
    return view('pages.bootstrap-table', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-tooltip', function () {
    return view('pages.bootstrap-tooltip', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-typography', function () {
    return view('pages.bootstrap-typography', ['type_menu' => 'bootstrap']);
});


// components

Route::get('/components-avatar', function () {
    return view('pages.components-avatar', ['type_menu' => 'components']);
});
Route::get('/components-chat-box', function () {
    return view('pages.components-chat-box', ['type_menu' => 'components']);
});
Route::get('/components-empty-state', function () {
    return view('pages.components-empty-state', ['type_menu' => 'components']);
});
Route::get('/components-gallery', function () {
    return view('pages.components-gallery', ['type_menu' => 'components']);
});
Route::get('/components-hero', function () {
    return view('pages.components-hero', ['type_menu' => 'components']);
});
Route::get('/submission', function () {
    return view('pages.submission', ['type_menu' => 'components']);
});
Route::get('/components-pricing', function () {
    return view('pages.components-pricing', ['type_menu' => 'components']);
});
Route::get('/components-statistic', function () {
    return view('pages.components-statistic', ['type_menu' => 'components']);
});
Route::get('/components-tab', function () {
    return view('pages.components-tab', ['type_menu' => 'components']);
});
Route::get('/components-table', function () {
    return view('pages.components-table', ['type_menu' => 'components']);
});
Route::get('/components-user', function () {
    return view('pages.components-user', ['type_menu' => 'components']);
});
Route::get('/components-wizard', function () {
    return view('pages.components-wizard', ['type_menu' => 'components']);
});

// forms
Route::get('/forms-advanced-form', function () {
    return view('pages.forms-advanced-form', ['type_menu' => 'forms']);
});
Route::get('/forms-editor', function () {
    return view('pages.forms-editor', ['type_menu' => 'forms']);
});
Route::get('/forms-validation', function () {
    return view('pages.forms-validation', ['type_menu' => 'forms']);
});

// google maps
// belum tersedia

// modules
Route::get('/modules-calendar', function () {
    return view('pages.modules-calendar', ['type_menu' => 'modules']);
});
Route::get('/modules-chartjs', function () {
    return view('pages.modules-chartjs', ['type_menu' => 'modules']);
});
Route::get('/modules-datatables', function () {
    return view('pages.modules-datatables', ['type_menu' => 'modules']);
});
Route::get('/modules-flag', function () {
    return view('pages.modules-flag', ['type_menu' => 'modules']);
});
Route::get('/modules-font-awesome', function () {
    return view('pages.modules-font-awesome', ['type_menu' => 'modules']);
});
Route::get('/modules-ion-icons', function () {
    return view('pages.modules-ion-icons', ['type_menu' => 'modules']);
});
Route::get('/modules-owl-carousel', function () {
    return view('pages.modules-owl-carousel', ['type_menu' => 'modules']);
});
Route::get('/modules-sparkline', function () {
    return view('pages.modules-sparkline', ['type_menu' => 'modules']);
});
Route::get('/modules-sweet-alert', function () {
    return view('pages.modules-sweet-alert', ['type_menu' => 'modules']);
});
Route::get('/modules-toastr', function () {
    return view('pages.modules-toastr', ['type_menu' => 'modules']);
});
Route::get('/modules-vector-map', function () {
    return view('pages.modules-vector-map', ['type_menu' => 'modules']);
});
Route::get('/modules-weather-icon', function () {
    return view('pages.modules-weather-icon', ['type_menu' => 'modules']);
});

// auth
Route::get('/auth-forgot-password', function () {
    return view('pages.auth-forgot-password', ['type_menu' => 'auth']);
});
Route::get('/auth-login', function () {
    return view('pages.auth-login', ['type_menu' => 'auth']);
});
Route::get('/login', function () {
    return view('pages.login', ['type_menu' => 'auth']);
});
Route::get('/auth-register', function () {
    return view('pages.auth-register', ['type_menu' => 'auth']);
});
Route::get('/auth-reset-password', function () {
    return view('pages.auth-reset-password', ['type_menu' => 'auth']);
});

// error
Route::get('/error-403', function () {
    return view('pages.error-403', ['type_menu' => 'error']);
});
Route::get('/error-404', function () {
    return view('pages.error-404', ['type_menu' => 'error']);
});
Route::get('/error-500', function () {
    return view('pages.error-500', ['type_menu' => 'error']);
});
Route::get('/error-503', function () {
    return view('pages.error-503', ['type_menu' => 'error']);
});

// features
Route::get('/features-activities', function () {
    return view('pages.features-activities', ['type_menu' => 'features']);
});
Route::get('/features-post-create', function () {
    return view('pages.features-post-create', ['type_menu' => 'features']);
});
Route::get('/features-post', function () {
    return view('pages.features-post', ['type_menu' => 'features']);
});
// Route::get('/profile', function () {
//     return view('pages.profile', ['type_menu' => 'features']);
// });
Route::get('/features-settings', function () {
    return view('pages.features-settings', ['type_menu' => 'features']);
});
Route::get('/features-setting-detail', function () {
    return view('pages.features-setting-detail', ['type_menu' => 'features']);
});
Route::get('/features-tickets', function () {
    return view('pages.features-tickets', ['type_menu' => 'features']);
});

// utilities
Route::get('/utilities-contact', function () {
    return view('pages.utilities-contact', ['type_menu' => 'utilities']);
});
Route::get('/utilities-invoice', function () {
    return view('pages.utilities-invoice', ['type_menu' => 'utilities']);
});
Route::get('/utilities-subscribe', function () {
    return view('pages.utilities-subscribe', ['type_menu' => 'utilities']);
});

// credits
Route::get('/credits', function () {
    return view('pages.credits', ['type_menu' => '']);
});
