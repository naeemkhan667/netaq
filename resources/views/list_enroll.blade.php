<div class="container mt-3">
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
                    <a href="{{ route('enrollment.registration') }}" class="btn btn-primary mb-3">User Registration</a>

                </div>
            </div>
            <div class="col-md-6" style="text-align: right">
                <select name="user_selected_id" style="height: 35px; vertical-align: bottom">
                    <option value=0>Select User</option>
                    @foreach ($user_dd as $user)
                        <option value="{{ $user->id }}" {{ $user_selected_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                </select>

                <select name="course_selected_id" style="height: 35px; vertical-align: bottom">
                    <option value=0>Select Course</option>
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
                <tr class="table-secondary">
                    <td>{{ $r['name'] }}</td>
                    <td>{{ $r['email'] }}</td>
                    <td></td>
                    <td>
                        <a href="{{ route('enrollment.add', ['user_id' => $r['id']]) }}"
                            class="btn btn-success">Enrollment</a>
                         <a href="{{ route('enrollment.registration.delete', ['user_id' => $r['id']]) }}"
                            class="btn btn-danger" onclick="return confirm('Are you sure to delete this entry?')" >Delete</a>
                    </td>
                </tr>

                @foreach ($r['courses'] as $c)
                    <tr class="table-light">
                        <td></td>
                        <td></td>
                        <td>
                            {{ $c['name'] }}

                            @if ($c['pivot']['course_status'] >= 2)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-warning">Active</span>
                            @endif


                        </td>
                        <td>
                            <a href="{{ route('enrollment.edit', ['user_id' => $r['id'], 'course_id' => $c['id'], 'id' => $c['pivot']['id'], 'course_status_id' => $c['pivot']['course_status']]) }}"
                                class="btn btn-primary btn-sm "> Edit </a>
                            <a href="{{ route('enrollment.delete', [ 'id' => $c['pivot']['id'] ] ) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure to delete this entry?')"
                            > Delete </a>
                        </td>
                    </tr>
                @endforeach
            @endforeach

        </tbody>
    </table>

</div>
