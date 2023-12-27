<div class="container mt-3">
    {{--  <h2>Striped Rows</h2>  --}}

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif




    <form action="/dashboard" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div>
                    <a href="{{route('enrollment.registration')}}" class="btn btn-primary mb-3">New Enrollment</a>

                </div>
            </div>
            <div class="col-md-6">
                <select name="user_selected_id">
                    <option value=0>Please Select...</option>
                    @foreach ($user_dd as $user)
                        <option value="{{ $user->id }}" {{ $user_selected_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach

                </select>

                <select name="course_selected_id">
                    <option value=0>Please Select...</option>
                    @foreach ($course_dd as $course)
                        <option value="{{ $course->id }}" {{ $course_selected_id == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}</option>
                    @endforeach

                </select>


                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>


    <table class="table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Enrolled Courses</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($results['data'] as $r)
                <tr class="table-success">
                    <td>{{ $r['name'] }}</td>
                    <td>{{$r['email']}}</td>
                    <td></td>
                    <td>
                        <a href="{{ route('enrollment.add', ['user_id' => $r['id']]) }}" class="btn btn-primary">Enrollment</a>
                        <a href="{{route('registration.delete', ['user_id' => $r['id']])}}" class="btn btn-danger"> Delete </a>
                    </td>
                </tr>

                @foreach ($r['courses'] as $c)
                    <tr class="table-active">
                        <td></td>
                        <td></td>
                        <td>{{ $c['name'] }}</td>
                        <td>
                            <a href="{{route('enrollment.edit', ['user_id' => $r['id'], 'course_id' => $c['id'], 'id' =>$c['pivot']['id'], 'course_status_id' => $c['pivot']['course_status'] ])}}" class="btn btn-primary"> Edit </a>
                            <a href="{{route('course.delete')}}" class="btn btn-danger"> Delete </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach

        </tbody>
    </table>
</div>
