<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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



Route::get('/login', [EnrollmentController::class, 'login'])->name('login');
Route::post('/login', [EnrollmentController::class, 'authenticate']);
Route::get('/register', [EnrollmentController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [EnrollmentController::class, 'logout'])->name('logout');
    Route::match(['get', 'post'], '/dashboard', [EnrollmentController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [EnrollmentController::class, 'index']);

    Route::prefix('enrollment')->group(function () {

        Route::get('/registration', [EnrollmentController::class, 'enrollment_registration'])->name('enrollment.registration');
        Route::post('/registration/save', [EnrollmentController::class, 'enrollment_registration_save'])->name('enrollment.registration.save');
        Route::get('/registration/delete', [EnrollmentController::class, 'enrollment_registration_delete'])->name('enrollment.registration.delete');

        Route::get('/add', [EnrollmentController::class, 'enrollment_add'])->name('enrollment.add');
        Route::post('/save', [EnrollmentController::class, 'enrollment_save'])->name('enrollment.save');

        Route::get('/edit', [EnrollmentController::class, 'enrollment_edit'])->name('enrollment.edit');
        Route::post('/update', [EnrollmentController::class, 'enrollment_update'])->name('enrollment.update');

        Route::get('/delete', [EnrollmentController::class, 'enrollment_delete'])->name('enrollment.delete');
        Route::get('/edit', [EnrollmentController::class, 'enrollment_edit'])->name('enrollment.edit');
    });

    Route::get('/registration/delete', [EnrollmentController::class, 'registration_delete'])->name('registration.delete');

    Route::get('/course/edit', [EnrollmentController::class, 'index'])->name('course.edit');
    Route::get('/course/delete', [EnrollmentController::class, 'index'])->name('course.delete');
});
