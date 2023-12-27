<?php

use App\Http\Controllers\EnrollmentController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


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



Route::get('/mywork',  function(){
    $response = Http::get('http://netaq.local/api/enrollments');

    /*$response->json();
    $response->getBody();
    $response->getBody()->getContent();*/

   //var_dump($response);
   //return "h";
    // $url = 'http://127.0.0.1:8000/api/enrollments';
    // $client = new \GuzzleHttp\Client();
    // $response = $client->get($url);
    // $response = ['hello'];
    $res = $response->json(); // $res['message'], $res['data'], $res['data']
   return view('test', ['data' => $response->json()]);

});



Route::post('/', function(Request $request){

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $token = $user->createToken('netaq')->plainTextToken;
        $data = ['name' => $user->name, 'token' => $token];



        return redirect()->route('dashboard');
     } else {
        return redirect()->route('/');
    }
});


//==============================
Route::get('/register', function(){
    return view('auth.register');
});


Route::get('/login', [EnrollmentController::class, 'login'])->name('login'); //ok
Route::get('/logout', [EnrollmentController::class, 'logout'])->name('logout'); //ok
Route::get('/register', [EnrollmentController::class, 'register'])->name('register');
Route::match(['get', 'post'], '/dashboard', [EnrollmentController::class, 'dashboard'])->name('dashboard'); //ok
Route::get('/', [EnrollmentController::class, 'index']);



Route::get('/enrollment/registration', [EnrollmentController::class, 'enrollment_registration'])->name('enrollment.registration'); //ok
Route::post('/enrollment/registration/save', [EnrollmentController::class, 'enrollment_registration_save'])->name('enrollment.registration.save');

Route::get('/enrollment/add', [EnrollmentController::class, 'enrollment_add'])->name('enrollment.add');
Route::post('/enrollment/save', [EnrollmentController::class, 'enrollment_save'])->name('enrollment.save');

Route::get('/enrollment/edit', [EnrollmentController::class, 'enrollment_edit'])->name('enrollment.edit');
Route::post('/enrollment/update', [EnrollmentController::class, 'enrollment_update'])->name('enrollment.update');


Route::get('/enrollment/delete', [EnrollmentController::class, 'enrollment_delete'])->name('enrollment.delete');
Route::get('/enrollment/edit', [EnrollmentController::class, 'enrollment_edit'])->name('enrollment.edit');
Route::get('/registration/delete', [EnrollmentController::class, 'registration_delete'])->name('registration.delete');

Route::get('/course/edit', [EnrollmentController::class, 'index'])->name('course.edit'); //TODO
Route::get('/course/delete', [EnrollmentController::class, 'index'])->name('course.delete'); //TODO

