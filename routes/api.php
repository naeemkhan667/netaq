<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EnrollmentController;

use App\Models\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//create enrollment [user_id, course_id]
Route::post('/enrollments', [EnrollmentController::class, 'store']);

//Get all enrollments
Route::get('/enrollments', [EnrollmentController::class, 'index']);

//Get all enrollments with course_id
Route::get('/enrollments/user/{user_id}', [EnrollmentController::class, 'enrollments_by_user']);

//Get all enrollments with user_id
Route::get('/enrollments/course/{course_id}', [EnrollmentController::class, 'enrollments_by_course']);

//Get all enrollments of a user by course_id
Route::get('/enrollments/user/{user_id}/course/{course_id}', [EnrollmentController::class, 'enrollments_user_by_course']);

//Update enrollment
Route::put('/enrollments/{id}', [EnrollmentController::class, 'update']); //TODO:? need to make it PUT

Route::delete('/enrollments/{id}', [EnrollmentController::class, 'delete']);

