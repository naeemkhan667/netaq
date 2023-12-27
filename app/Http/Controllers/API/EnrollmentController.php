<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $enrollments = User::with('courses')->get();
        return response()->json(['status' => true, 'message' => 'Data successfully fetched', 'data' => $enrollments], 200);

    }
    public function enrollments_by_user(Request $request, $user_id)
    {
        return User::with('courses')->where('id', $user_id)->get();
    }

    public function enrollments_by_course(Request $request, $course_id)
    {
        return Course::with('users')->where('id', $course_id)->get();
    }
    public function enrollments_user_by_course(Request $request, $user_id, $course_id) {
        return $user = User::with(['courses' => function($query) use ($course_id){
            $query->where('courses.id', $course_id);
        }])->where('id', $user_id)->get();

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
            $user->courses()->sync([$course_id]);
            return response()->json(['status' => true, 'message' => 'Enrollment Successfully Created'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error']);
        }
    }
    public function update(Request $request, $course_id)
    {
        try {
            $validator = Validator::make($request->all(), ['user_id' => 'required|numeric', 'course_id' => 'required|numeric']);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $user_id = $request->user_id;
            $course_id = $request->course_id;
            $user = User::find($user_id);
            $user->courses()->sync([$course_id]);
            return response()->json(['success'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error']);
        }
    }
}