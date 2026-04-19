<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Import Export Excel to Database Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>

<div class="container">
    <div class="card mt-5">
        <h3 class="card-header p-3"><i class="fa fa-star"></i> Laravel 11 Import Export Excel to Database Example - ItSolutionStuff.com</h3>
        <div class="card-body">

            @session('success')
                <div class="alert alert-success" role="alert">
                    {{ $value }}
                </div>
            @endsession

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="file" name="file" class="form-control">

                <br>
                <button class="btn btn-success"><i class="fa fa-file"></i> Import User Data</button>
            </form>

            <table class="table table-bordered mt-3">
                <tr>
                    <th colspan="7">
                        List Of Users
                        <a class="btn btn-warning float-end" href="{{ route('students.export') }}"><i class="fa fa-download"></i> Export User Data</a>
                    </th>
                </tr>
                <tr>
                    <th hidden>ID</th>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Course ID</th>
                    <th>Year Level</th>
                    <th>Enrolled</th>
                    <th>Student Status</th>
                </tr>
                @foreach($students as $s)
                <tr>
                    <td hidden>{{ $s->id }}</td>
                    <td>{{ $s->sid }}</td>
                    <td>{{ $s->fullname }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->course_code }}</td>
                    <td>{{ $s->year_level }}</td>
                    <td>{{ $s->enroll_status ? 'Yes' : 'No' }}</td>
                    <td>{{ $s->student_status }}</td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>

</body>
</html>
