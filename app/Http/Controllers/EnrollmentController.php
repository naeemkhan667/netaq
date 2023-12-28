<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStatus;
use App\Models\User;
use CreateCoursesTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class EnrollmentController extends Controller
{

    private $api_base_url = "http://netaq.local/";

    public function __construct()
    {

    }

    public function api_token(){
        return session('api_token');
    }
    public function index()
    {
        if (Auth::check()) {

            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function login()
    {
        //dd('here....');
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function authenticate(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('netaq')->plainTextToken;
            $data = ['name' => $user->name, 'token' => $token];
            session(['api_token' => $token]);
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('/');
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function dashboard(Request $request)
    {

        $user_selected_id = $request->user_selected_id;
        $course_selected_id = $request->course_selected_id;


        if (!empty($user_selected_id) && !empty($course_selected_id)) {
            // /enrollments/user/{user_id}/course/{course_id}
            $url = $this->api_base_url . "api/enrollments/user/$user_selected_id/course/$course_selected_id";
        } else if (empty($user_selected_id) && !empty($course_selected_id)) {
            // /enrollments/course/{course_id}
            $url = $this->api_base_url . "api/enrollments/course/$course_selected_id";
        } else if (!empty($user_selected_id) && empty($course_selected_id)) {
            // /enrollments/user/{user_id}
            $url = $this->api_base_url . "api/enrollments/user/$user_selected_id";
        } else {
            $url = $this->api_base_url . 'api/enrollments';
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token()
        ])->get($url);

        if (Auth::check()) {

            $user_dd = User::select('id', 'name')->get();
            $course_dd = Course::select('id', 'name')->get();
            $data = [
                'user_dd' => $user_dd, 'user_selected_id' => $user_selected_id,
                'course_dd' => $course_dd, 'course_selected_id' => $course_selected_id,
                'results' => $response->json()
            ];

            return view('main', $data);
        }
        return redirect()->route('login');
    }

    public function enrollment_registration()
    {
        return view('enrollment_registration');
    }
    public function enrollment_add(Request $request)
    {
        $users = User::all();
        $courses = Course::all();
        $data = ['users' => $users, 'courses' => $courses, 'selected_user_id' => $request->query('user_id')];
        return view('enrollment_add', $data);
    }
    public function enrollment_save(Request $request)
    {
        //var_dump($request->all());
        $enrollment_route = $this->api_base_url . "api/enrollments";
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token()
            ])->post($enrollment_route, [
                'user_id' => $request->user_id,
                'course_id' => $request->course_id
            ]);

            $enrollment_response = $response->json();

            if ($enrollment_response['status'] == false) {
                return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            Log::error($e->getMessage());
        }
        return redirect('dashboard')->with(['success' => $enrollment_response['message']]);
    }


    public function enrollment_delete(Request $request)
    {

        $id = $request->id;
        $enrollment_route = $this->api_base_url . "api/enrollments/" . $id;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token()
            ])->delete($enrollment_route);

            $enrollment_response = $response->json();

            if ($enrollment_response['status'] == false) {
                return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            Log::error($e->getMessage());
        }
        return redirect('dashboard')->with(['success' => $enrollment_response['message']]);
    }

    public function enrollment_edit(Request $request)
    {

        $course_status = CourseStatus::all();
        $users = User::all();
        $courses = Course::all();
        $data = [
            'users' => $users, 'selected_user_id' => $request->query('user_id'),
            'courses' => $courses, 'selected_course_id' => $request->query('course_id'),
            'course_status' => $course_status, 'selected_status_id' => $request->query('course_status_id'),
            'id' => $request->query('id')
        ];

        return view('enrollment_edit', $data);
    }
    public function enrollment_update(Request $request)
    {
        $rec_id = $request->id;
        $enrollment_route = $this->api_base_url . "api/enrollments/" . $rec_id;

        try {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token()
            ])->put($enrollment_route, [
                'user_id' => $request->user_id,
                'course_id' => $request->course_id,
                'course_status' => $request->status_id
            ]);

            $enrollment_response = $response->json();

            if ($enrollment_response['status'] == false) {
                return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            Log::error($e->getMessage());
        }
        return redirect('dashboard')->with(['success' => $enrollment_response['message']]);
    }

    public function enrollment_registration_delete(Request $request)
    {

        $rec_id = $request->user_id;
        $enrollment_route = $this->api_base_url . "api/enrollments/registration/" . $rec_id;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token()
            ])->delete($enrollment_route);

            $enrollment_response = $response->json();

            if ($enrollment_response['status'] == false) {
                return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            Log::error($e->getMessage());
        }
        return redirect('dashboard')->with(['success' => $enrollment_response['message']]);
    }
    public function enrollment_registration_save(Request $request)
    {

        $register_route = $this->api_base_url . "api/register";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token()
            ])->post($register_route, [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'confirm_password' => $request->confirm_password
            ]);

            $registration_response = $response->json();

            if ($registration_response['status'] == false) {
                return redirect()->back()->withErrors(['custom_error' => $registration_response['message']]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['custom_error' => $e->getMessage()]);
        }
        return redirect()->route('dashboard')->with('success', 'Registration Successfully Created');
    }
}
