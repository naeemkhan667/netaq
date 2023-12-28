@extends('layouts.auth')
@section('contents')
    <div id="layoutAuthentication">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Login</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputEmail" type="email" name="email"
                                        placeholder="name@example.com" />
                                    <label for="inputEmail">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                                    <label for="inputPassword">Password</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                   <button type="submit" class="btn btn-primary"> Login </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @section('footer')
        @include('layouts.footer')
    @endsection

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
@endsection
