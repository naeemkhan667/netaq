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
                            <h3 class="text-center font-weight-light my-4">User Registration</h3>
                        </div>

                        <div class="form-floating mb-3 mx-3 mt-3">
                            @if ($errors->has('custom_error'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('custom_error') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action="{{ route('enrollment.registration.save') }}" method="POST">

                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="username" type="text" name="name"
                                        placeholder="Enter your first name" />
                                    <label for="inputFirstName">User Name</label>
                                </div>





                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputEmail" type="email" name="email"
                                        placeholder="name@example.com" />
                                    <label for="inputEmail">Email address</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputPassword" type="password" name="password"
                                        placeholder="Create a password" />
                                    <label for="inputPassword">Password</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputPasswordConfirm" type="password"
                                        name="confirm_password" placeholder="Confirm password" />
                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                </div>


                                <div class="mt-4 mb-0">
                                    {{--  <div class="d-grid"><a class="btn btn-primary btn-block" href="login.html">Register/Enroll</a></div>  --}}
                                    <button type="submit" class="btn btn-primary">Register</button>
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
