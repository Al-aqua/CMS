<?php
use App\Http\Controllers\Student\AnnouncementController;
use App\Http\Controllers\Student\ChapterController;
use App\Http\Controllers\Student\ChatController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\LectureController;
use App\Http\Controllers\Student\QuizController;
use App\Http\Controllers\Student\AssignmentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['student'], 'prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::post('/register', [CourseController::class, 'store'])->name('register');
        Route::get('/info/{slug}', [CourseController::class, 'info'])->name('info');

        Route::group(['prefix' => 'chapters', 'as' => 'chapters.'], function () {
            Route::get('view/{id}', [ChapterController::class, 'index'])->name('view');
        });

        Route::group(['prefix' => 'assignments', 'as' => 'assignments.'], function () {
            Route::get('/{course_id}', [AssignmentController::class, 'index'])->name('index');
            Route::post('store/{id}', [AssignmentController::class, 'store'])->name('store');
        });
        Route::group(['prefix' => 'chat', 'as' => 'chat.'], function () {
            Route::post('store', [ChatController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'quizzes', 'as' => 'quizzes.'], function () {
            Route::get('/{course_id}', [QuizController::class, 'index'])->name('index');
            Route::get('/show/{quiz}', [QuizController::class, 'show'])->name('show');
            Route::post('/remaining_time', [QuizController::class, 'remaining_time'])->name('remaining_time');
        });

        Route::group(['prefix' => 'announcements', 'as' => 'announcements.'], function () {
            Route::get('/{course_id}', [AnnouncementController::class, 'index'])->name('index');
            Route::post('/store', [AnnouncementController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'materials', 'as' => 'materials.'], function () {
            Route::get('/view/{id}', [\App\Http\Controllers\Student\MaterialController::class, 'view'])->name('view');
        });

        Route::group(['prefix' => 'content', 'as' => 'content.'], function () {
            Route::get('/', [\App\Http\Controllers\Student\ContentController::class, 'index'])->name('index');
        });

        Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {
            Route::get('/view/{course_id}/{lecture_id}', [LectureController::class, 'view'])->name('view');
            Route::group(['prefix' => 'activities', 'as' => 'activities.'], function () {
                Route::get('/', [LectureController::class, 'view'])->name('view');
                Route::post('/', [LectureController::class, 'store'])->name('store');
            });
        });
    });

    Route::group(['prefix' => 'enrollment', 'as' => 'enrollment.'], function () {
        Route::get('/courses', [EnrollmentController::class, 'courses'])->name('courses');
        Route::get('/course/{slug}', [EnrollmentController::class, 'index'])->name('index')->middleware('course');
        Route::get('/course/view/{id}', [EnrollmentController::class, 'view'])->name('view');
        Route::post('register/{id}', [EnrollmentController::class, 'register'])->name('register');
    });
});
