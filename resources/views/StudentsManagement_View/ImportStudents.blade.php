@extends('adminlte::page')

@section('title', 'Student Import & Export')

@section('content_header')
    <h1>Student Import & Export</h1>
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('StudentsManagement_pagination') }}">Student Management</a></li>
        <li class="breadcrumb-item">Student Import & Export</li>
    </ol>

@stop

@section('content')

<div class="container">
    <div class="card ">
        <h3 class="card-header p-3"><i class="fa fa-star"></i> Laravel 11 Import Export Excel to Database Example - ItSolutionStuff.com</h3>
        <div class="card-body">

            @session('success')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle"></i> {{ $value }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endsession

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-exclamation-triangle"></i> Validation Errors:</strong><br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle"></i> {{ session('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- FILE UPLOAD FORM -->
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf

                <div class="mb-3">
                    <label for="file" class="form-label">Select Excel/CSV File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success"><i class="fa fa-file"></i> Load & Preview</button>
                    <a href="{{ route('students.downloadTemplate') }}" class="btn btn-info"><i class="fa fa-download"></i> Download Template</a>
                </div>
            </form>

            <hr>

            <!-- PREVIEW & CONFIRMATION SECTION -->
            @if (!empty($students) && session('import_students'))
                <div class="alert alert-warning">
                    <strong>⚠ Preview Mode:</strong> Review the data below. Click "Confirm Import" to save to database or "Cancel" to discard.
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <tr>
                        <th colspan="8">
                            @if (session('import_students'))
                                <span>📋 Import Preview ({{ count($students) }} rows)</span>
                            @else
                                <span>List Of Students in Database</span>
                                <a class="btn btn-warning float-end" href="{{ route('students.export') }}"><i class="fa fa-download"></i> Export Students</a>
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Course Code</th>
                        <th>Year Level</th>
                        <th>Student Status</th>
                        <th>Enrolled</th>
                        <th>Term / SY</th>
                    </tr>
                    @foreach($students as $s)
                    <tr>
                        <td>{{ $s['sid'] ?? $s->sid ?? '-' }}</td>
                        <td>{{ $s['fullname'] ?? $s->fullname ?? '-' }}</td>
                        <td>{{ $s['email'] ?? $s->email ?? '-' }}</td>
                        <td>{{ $s['course_code'] ?? $s->course_code ?? '-' }}</td>
                        <td>{{ $s['year_level'] ?? $s->year_level ?? '-' }}</td>
                        <td>{{ $s['student_status'] ?? $s->student_status ?? '-' }}</td>
                        <td>{{ ($s['enroll_status'] ?? $s->enroll_status ?? 0) ? 'Yes' : 'No' }}</td>
                        <td>{{ ($s['term'] ?? $s->term ?? '') . ' / ' . ($s['sy'] ?? $s->sy ?? '') }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <!-- ACTION BUTTONS -->
            @if (session('import_students'))
                <div class="mt-4">
                    <form method="POST" action="{{ route('students.saveImport') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-check"></i> Confirm Import</button>
                    </form>
                    <form method="POST" action="{{ route('students.cancelImport') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg"><i class="fa fa-times"></i> Cancel Import</button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Auto-close alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000); // 5000 milliseconds = 5 seconds
</script>
@stop

@section('css')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons-text-hover-effect.css') }}">
@stop
