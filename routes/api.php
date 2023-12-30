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

//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Authenticated routes
Route::middleware('auth:sanctum')->prefix('enrollments')->group(function () {

    //create enrollment [user_id, course_id]
    Route::post('/', [EnrollmentController::class, 'store']);//TODO? needd to check enrollments shouldn't be here

    //Get all enrollments
    Route::get('/', [EnrollmentController::class, 'index']);

    //Get all enrollments with course_id
    Route::get('/user/{user_id}', [EnrollmentController::class, 'enrollments_by_user']);

    //Get all enrollments with user_id
    Route::get('/course/{course_id}', [EnrollmentController::class, 'enrollments_by_course']);

    //Get all enrollments of a user by course_id
    Route::get('/user/{user_id}/course/{course_id}', [EnrollmentController::class, 'enrollments_user_by_course']);

    //Update enrollment
    Route::put('/{id}', [EnrollmentController::class, 'update']); //TODO:? need to make it PUT

    //Deleting an enrollment
    Route::delete('/{id}', [EnrollmentController::class, 'enrollment_delete']);

    //Deleting a registration
    //Route::delete('/registration/{id}', [EnrollmentController::class, 'registration_delete']);
    Route::delete('/registration/{id}', [EnrollmentController::class, 'registration_delete']);

});

//Handle bad rotues
Route::any('{any}', function(){
    return response()->json(['status' => false, 'message'   => 'Page not Found.'], 404);
})->where('any', '.*');
