<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\CourseUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        try {

            $enrollments = User::with('courses')->orderby('id' ,'desc')->get();
            return response()->json(['status' => true, 'message' => 'Data Successfully fetched', 'data' => $enrollments], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
    public function enrollments_by_user(Request $request, $user_id)
    {
        try {
            $enrollments = User::with('courses')->where('id', $user_id)->get();
            return response()->json(['status' => true, 'message' => 'Data Successfully fetched', 'data' => $enrollments], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function enrollments_by_course(Request $request, $course_id)
    {
        try {
            $enrollments = User::whereHas('courses', function ($query) use ($course_id) {
                $query->where('courses.id', $course_id);
            })->with('courses')->get();


            return response()->json(['status' => true, 'message' => 'Data Successfully fetched', 'data' => $enrollments], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
    public function enrollments_user_by_course(Request $request, $user_id, $course_id)
    {
        try {
            $enrollments = $user = User::with(['courses' => function ($query) use ($course_id) {
                $query->where('courses.id', $course_id);
            }])->where('id', $user_id)->get();
            return response()->json(['status' => true, 'message' => 'Data Successfully fetched', 'data' => $enrollments], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['user_id' => 'required|numeric|not_in:0', 'course_id' => 'required|numeric|not_in:0']);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $user_id = $request->user_id;
            $course_id = $request->course_id;
            $user = User::find($user_id);
            $user->courses()->attach([$course_id]);

            return response()->json(['status' => true, 'message' => 'Enrollment Successfully Created'], 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            CourseUser::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|numeric|not_in:0',
                'course_id' => 'required|numeric|not_in:0',
                'course_status' => 'nullable|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $user_id = $request->user_id;
            $course_id = $request->course_id;
            $course_status = $request->course_status;

            DB::delete('delete from course_user WHERE id = ?', [$id]);
            $results = DB::insert('INSERT INTO course_user (user_id, course_id, course_status) VALUES (?, ?, ?) ', [$user_id, $course_id, $course_status]);
            if (!$results) {
                return response()->json(['status' => false, 'message' => 'Unknow error occured'], 404);
            }
            return response()->json(['status' => true, 'message' => 'Enrollment Successfully Updated'], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
    public function enrollment_delete(Request $request, $id)
    {
        //dd($request->all());
        try {
            CourseUser::findOrFail($id);
            $results = DB::delete('DELETE FROM course_user WHERE id = ?', [$id]);
            if (!$results) {
                return response()->json(['status' => false, 'message' => 'Unknow error occured'], 404);
            }
            return response()->json(['status' => true, 'message' => 'Enrollment Successfully Deleted'], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'],  500);
        }
    }
    public function registration_delete(Request $request, $id){
        try {
            User::findOrFail($id);
            $results = DB::delete('DELETE FROM users WHERE id = ?', [$id]);
            if (!$results) {
                return response()->json(['status' => false, 'message' => 'Unknow error occured'], 404);
            }
            return response()->json(['status' => true, 'message' => 'Registration Successfully Deleted'], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => 'Internal Server Error'],  500);
        }
    }
}
