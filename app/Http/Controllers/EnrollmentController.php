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

class EnrollmentController extends Controller
{

    private $api_base_url = "http://netaq.local/";
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
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
        //var_dump($request->all());

        //$response = Http::get('http://netaq.local/api/enrollments');
        $response = Http::get($this->api_base_url . 'api/enrollments');

        //var_dump($response->json());

        if (Auth::check()) {

            $user_selected_id = $request->user_selected_id;
            $course_selected_id = $request->course_selected_id;


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
    public function enrollment_save(Request $request){
            var_dump($request->all());
            $enrollment_route = $this->api_base_url . "api/enrollments";
            try{
                $response = Http::post($enrollment_route, [
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id
                ]);

                $enrollment_response = $response->json();

                if ($enrollment_response['status'] == false) {
                    return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
                }

            }catch(Exception $e){
                return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            }
            return redirect('dashboard')->with(['success' => $enrollment_response['message']]);
    }

    public function enrollment_delete()
    {
        return "enrollment_delete";
    }

    public function enrollment_edit(Request $request)
    {
        $status = CourseStatus::all();
        $users = User::all();
        $courses = Course::all();
        $data = [
            'users' => $users, 'selected_user_id' => $request->query('user_id'),
            'courses' => $courses, 'selected_course_id' => $request->query('user_id'),
            'status' => $status, 'selected_status_id' => $request->query('status')
         ];

        //return view('enrollment_add', $data);
        dd($data);

        return "enrollment_edit";

    }
    public function enrollment_update()
    {
        return "enrollment_edit";
    }

    public function registration_delete()
    {
        return "registration_delete";
    }
    public function enrollment_registration_save(Request $request)
    {

        $enrollment_route = $this->api_base_url . "api/enrollments";
        $register_route = $this->api_base_url . "api/register";

        try {
            $response = Http::post($register_route, [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'confirm_password' => $request->confirm_password
            ]);

            $registration_response = $response->json();

            if ($registration_response['status'] == false) {
                return redirect()->back()->withErrors(['custom_error' => $registration_response['message']]);
            }


            $user_id = $registration_response['data']['user_id'];
            $course_id = $request->course_id;

            $enrollment_response = Http::post($enrollment_route, [
                'user_id' => $user_id,
                'course_id' => $course_id
            ]);

            if ($enrollment_response['status'] == false) {
                return redirect()->back()->withErrors(['custom_error' => $enrollment_response['message']]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['custom_error' => "Internal Server Error"]);
        }
        return redirect()->route('dashboard')->with('success', 'Enrollment successfully created');
    }
}