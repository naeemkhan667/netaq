@extends('layouts.app')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('contents')

<div id="layoutAuthentication">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Create Enrollment</h3>
                    </div>

                    <div class="form-floating mb-3 mx-3 mt-3">
                        @if ($errors->has('custom_error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('custom_error') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('enrollment.save') }}" method="POST">

                            @csrf

                            <div class="form-floating mb-3">
                                <select name="user_id" id="user_id" style="width:100%; height:55px;">
                                    <option value="0">Select User</option>
                                    @foreach ($users as $user)
                                        <option value={{$user['id']}} {{$selected_user_id == $user['id'] ? 'selected' : ''}}>{{$user['name']}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-floating mb-3">
                                <select name="course_id" id="course_id" style="width:100%; height:55px;">
                                    <option value="0">Select Course</option>
                                    @foreach ($courses as $course)
                                        <option value={{$course['id']}}>{{$course['name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4 mb-0">
                               <button type="submit" class="btn btn-primary">Enroll</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
