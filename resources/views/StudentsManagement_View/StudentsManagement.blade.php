@extends('adminlte::page')
@section('title', 'Students Dashboard')
@section('content_header')
    <h1 class="mt-3">Student Management</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" ><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Student Management</li>
        <li></li>
    </ol>
    {{-- Search bar --}}
    <div class="row mb-2 justify-content-end">
        <div class="col-md-6">
            <div class="position-relative">
                <div class="input-group">
                    <input type="text" id="searchTableInput" class="form-control" placeholder="Search by name or student ID">
                    <button type="button" class="btn btn-outline-secondary" id="searchTableBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="searchSuggestions" class="list-group position-absolute w-100 mt-1 d-none" style="z-index:1050;"></div>
            </div>
        </div>
    </div>
@stop
@section('content')

{{-- table for Students List--}}
<div class="row">

    <div class="container-fluid">
        {{-- Small boxes for displaying statistics --}}
        <!-- SUMMARY CARDS -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="fw-bold">{{ count($student) + 1 }}</h2>
                        <a class="text-muted">Total of {{ $user->organization_id ? optional($organizations->where('id', $user->organization_id)->first())->name ?? 'Organization #'.$user->organization_id : '' }} Members</a>
                        <h4 class="fas fa-users text-success float-right"></h4>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="fw-bold">{{ count($student->where('student_status', 'New')) }}</h2>
                        <a class="text-muted ">Fresh Men</a>
                        <h4 class="fas fa-user-plus text-danger float-right"></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="fw-bold">{{ count($student->where('student_status', 'Old')) }}</h2>
                        <a class="text-muted">Previews Students</a>
                        <h4 class="fas fa-user-graduate text-primary float-right"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card-header mb-1" style="display: flex; justify-content: flex-end;">
            <div class="card-tools col-md-6" style="display: flex; gap: 15px;">
                <a type="button" class="btn btn-add  add-modal-record shadow" style="width: 200px;"  data-toggle="modal" data-target="#AddStudentForm">
                        <i class="fas fa-user-plus"></i> Add New Student
                </a>
                <a type="button" class="btn btn-success shadow" href="{{route('/StudentsManagement_View/ImportStudents')}}" style="width: 200px; border-radius: 7px;">
                    <i class="fas fa-file-import"></i> Import Students
                </a>
                <a type="button" class="btn btn-import shadow" href="{{route('/StudentsManagement_View/AssignQr_Rfid')}}" style="width: 200px;">
                    <i class="fas fa-qrcode"></i> Assign QR/RFID
                </a>
            </div>

        </div>

        <div class="card">
            <div class="card-header ">
                <h4 class="card-title">Students List</h4>
                <div class="card-tools" style="display: flex; justify-content: flex-end; width: 1000px;">
                    <!-- Filters Row -->
                    <div class="row col-12" >
                        <div class="col-md-2">
                            <select id="filter-course" class="form-control">
                                <option value="">Course</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="filter-year" class="form-control">
                                <option value="">Year Level</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter-enroll" class="form-control">
                                <option value="">Enrolled Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter-status" class="form-control">
                                <option value="">Student Status</option>
                                <option value="New">New</option>
                                <option value="Old">Old</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select id="sort-order" class="form-control">
                                <option value="az">A-Z</option>
                                <option value="za">Z-A></option>
                            </select>
                        </div>
                        <i class=" fas fa-filter" style="justify-content: center; display: flex; align-items: center;">Filter</i>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-hover" id="student">
                    <thead>
                        <tr>
                            <th hidden>ID</th>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Course ID</th>
                            <th>Year Level</th>
                            <th>Enrolled</th>
                            <th>Student Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student as $s)
                        <tr>
                            <td hidden>{{ $s->id }}</td>
                            <td>{{ $s->sid }}</td>
                            <td>{{ $s->fullname }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->course_code }}</td>
                            <td>{{ $s->year_level }}</td>
                            <td>{{ $s->enroll_status }}</td>
                            <td>{{ $s->student_status }}</td>

                            <td class="btn-groups justify-content-center">
                                <a href="{{ route('/StudentsManagement_View/StudentProfile', $s->id) }}" class="btn btn-info view-btn shadow">
                                        <i class="fas fa-eye"></i>
                                </a>
                                <a hidden href="#" class="btn btn-info view-btn view-modal-record shadow"
                                    data-toggle="modal"
                                    data-target="#ViewStudentModal"
                                        data-sid="{{ $s->sid }}"
                                        data-lname="{{ $s->lname }}"
                                        data-fname="{{ $s->fname }}"
                                        data-mname="{{ $s->mname }}"
                                        data-fullname="{{ $s->fullname }}"
                                        data-email="{{ $s->email }}"
                                        data-address="{{ $s->address }}"
                                        data-area_code="{{ $s->area_code }}"
                                        data-college_code="{{ $s->college_code }}"                            data-course_code="{{ $s->course_code }}"
                                        data-year_level="{{ $s->year_level }}"
                                        data-term="{{ $s->term }}"
                                        data-sy="{{ $s->sy }}"
                                        data-enroll_status="{{ $s->enroll_status }}"
                                        data-status="{{ $s->student_status }}">
                                        <i class="fas fa-eye"> </i>
                                </a>
                                <a href="#" class="btn btn-warning edit-btn edit-student-modal  shadow" data-toggle="modal" data-target="#EditStudentForm"
                                    data-id="{{ $s->id }}"
                                    data-rid="{{ $s->rid }}"
                                    data-sid="{{ $s->sid }}"
                                    data-lname="{{ $s->lname }}"
                                    data-fname="{{ $s->fname }}"
                                    data-mname="{{ $s->mname }}"
                                    data-fullname="{{ $s->fullname }}"
                                    data-email="{{ $s->email }}"
                                    data-area_code="{{ $s->area_code }}"
                                    data-college_code="{{ $s->college_code }}"
                                    data-course_code="{{ $s->course_code }}"
                                    data-year_level="{{ $s->year_level }}"
                                    data-term="{{ $s->term }}"
                                    data-sy="{{ $s->sy }}"
                                    data-student_status="{{ $s->student_status }}"
                                    data-enroll_status="{{ $s->enroll_status }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger delete-btn delete-modal-record shadow"
                                data-toggle="modal" data-target="#DeleteStudentForm"
                                    data-id="{{ $s->id }}"
                                    data-fullname="{{ $s->fullname }}">
                                    <i class="fas fa-trash"> </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- FOOTER -->
            <div class="card-footer d-flex justify-content-between">
                <small class="text-muted">
                    Total: {{ count($student) }} records
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Import Student Info CSV Modal -->
<div class="modal fade" id="importStudentModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <form id="importStudentForm"
                  method="POST"
                  action="{{ route('students.import') }}"
                  enctype="multipart/form-data">
                @csrf

                <!-- Modal Header -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title">Import Student Information (CSV)</h5>
                    <button type="button" class="close text-danger" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <!-- File Upload -->
                    <div class="form-group">
                        <label for="student_csv"><strong>Select CSV File</strong></label>
                        <input type="file"
                               class="form-control"
                               id="student_csv"
                               name="student_csv"
                               accept=".csv">

                        <small class="text-muted">
                            Accepted format: .csv (max 2MB)<br>
                            Required columns:
                            rid, sid, lname, fname, mname, fullname, email,
                            area_code, college_code, course_code, year_level,
                            term, sy, student_status, enroll_status
                        </small>
                    </div>

                    <hr>

                    <!-- Preview Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Preview</h6>
                        <span class="badge badge-primary" id="studentRowCountBadge">
                            Rows: 0
                        </span>
                    </div>

                    <!-- Preview Table -->
                    <div id="studentPreviewContainer"
                         class="table-responsive"
                         style="max-height:400px; overflow-y:auto;">
                    </div>

                    <hr>

                    <!-- Security Scan Results -->
                    <div id="studentScanResults" class="mb-3"></div>

                    <!-- Validation Section -->
                    <div id="studentValidationSection" style="display:none;">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Validated Student Records</h6>
                            <span class="badge badge-info" id="studentValidatedCountBadge">
                                Valid: 0
                            </span>
                        </div>

                        <!-- Validated Table -->
                        <div id="validatedStudentContainer"
                             class="table-responsive"
                             style="max-height:400px; overflow-y:auto;">
                        </div>

                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">

                    <!-- Clear Button -->
                    <button type="button"
                            class="btn btn-danger"
                            id="clearStudentImportBtn">
                        Clear
                    </button>

                    <!-- Import Button -->
                    <button type="button"
                            class="btn btn-success"
                            id="importStudentBtn"
                            disabled>
                        Import Students
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="AddStudentForm">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <form method="POST" action="{{ url('/store_student') }}">
            @csrf

            <div class="modal-content">

                <div class="modal-header ">
                    <h5 class="modal-title text-dark">Add Student</h5>
                    <button type="button" class="close text-danger" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <h6 class="text-muted text-uppercase small font-weight-bold mb-1 col-md-12">
                            <i class="fas fa-user mr-2"></i>Personal Information
                        </h6>
                        <div class="form-group col-md-6">
                            <label>ID Number</label>
                            <input type="text" name="s_sid" class="form-control">
                        </div>

                         <div class="form-group col-md-6">
                            <label>Role</label>
                            <select name="s_rid" class="form-control">
                                <option value="">Select Role</option>
                                @foreach($roles ?? [] as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" name="s_lname" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>First Name</label>
                            <input type="text" name="s_fname" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Middle Name</label>
                            <input type="text" name="s_mname" class="form-control">
                        </div>

                        <h6 class="text-muted text-uppercase small font-weight-bold mb-1 col-md-12">
                            <i class="fas fa-envelope mr-2"></i>Contact Information
                        </h6>
                        <div class="form-group col-md-8">
                            <label>Email</label>
                            <input type="email" name="s_email" class="form-control">
                        </div>

                        <h6 class="text-muted text-uppercase small font-weight-bold mb-1 col-md-12">
                            <i class="fas fa-graduation-cap mr-2"></i>Academic Information
                        </h6>
                        <div class="form-group col-md-6">
                            <label>Course Code</label>
                            <select name="s_course_code" class="form-control">
                                <option value="">Select Course</option>
                                @foreach($programs ?? [] as $p)
                                    <option value="{{ $p->id }}">{{ $p->code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Year Level</label>
                            <select name="s_year_level" class="form-control">
                                <option value="">Select Year Level</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>

                        </div>

                        <div class="form-group col-md-6">
                            <label>Enrollment Status</label>
                            <select name="s_enroll_status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Student Status</label>
                            <select name="s_student_status" class="form-control">
                                <option value="New" selected>New</option>
                                <option value="Old">Old</option>
                            </select>
                        </div>

                        <div class="form-group row" hidden>
                            <h6 class="text-muted text-uppercase small font-weight-bold mb-1 col-md-12">
                                <i class="fas fa-map-marker-alt mr-2"></i>Allocation Information
                            </h6>
                            <div class="form-group col-md-6" >
                                <label for="area_code">Campus</label>
                                <input type="text" class="form-control" id="area_code" name="s_area_code" value="{{ $user->area_code ?? '' }}" readonly required>
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="college_id_display">College</label>
                                <input type="text" class="form-control" id="college_id_display" value="{{ optional($colleges->where('id', $user->college_id ?? $user->department_id)->first())->name ?? '' }}" readonly>
                                <input type="hidden" id="s_college_code" name="s_college_code" value="{{ old('s_college_code', $user->college_id ?? $user->department_id ?? '') }}">
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="organization_id_display">Organization</label>
                                <input type="text" class="form-control" id="organization_id_display" value="{{ $user->organization_id ? optional($organizations->where('id', $user->organization_id)->first())->name ?? 'Organization #'.$user->organization_id : '' }}" readonly>
                                <input type="hidden" id="s_organization_id" name="s_organization_id" value="{{ old('s_organization_id', $user->organization_id ?? '') }}">
                            </div>
                            <input type="hidden" name="s_term" value="{{ old('s_term', '') }}">
                            <input type="hidden" name="s_sy" value="{{ old('s_sy', '') }}">
                            <input type="hidden" name="s_password" value="{{ old('s_password', '') }}">

                            {{-- <h6 class="text-muted text-uppercase small font-weight-bold mb-1 col-md-12">
                                <i class="fas fa-clock mr-2"></i>Time Allocation Information
                            </h6>
                            <div class="form-group col-md-4">
                                <label>Term</label>
                                <input type="text" name="s_term" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label>School Year</label>
                                <input type="text" name="s_sy" class="form-control">
                            </div> --}}
                        </div>

                    </div>
                </div>

                <div class="modal-footer d-flex" style="gap: 10px;">
                    <button type="button" class="btn btn-outline-secondary col-md-2" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-success col-md-3">
                        <span class="fas fa-save"></span> Save Student
                    </button>

                </div>

            </div>
        </form>
    </div>
</div>

<!-- View Student Modal -->
<div class="modal fade" id="ViewStudentModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

                <div class="modal-header text-dark">
                    <h5>Student Details</h5>
                    <button type="button" class="close text-danger" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>


            <div class="modal-body">

                <div class="row">

                    <div class="col-md-4" hidden>
                        <strong>Student ID:</strong>
                        <p id="s_sid" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Last Name:</strong>
                        <p id="s_lname" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>First Name:</strong>
                        <p id="s_fname" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Middle Name:</strong>
                        <p id="s_mname" class="text-muted"></p>
                    </div>

                    <div class="col-md-6">
                        <strong>Full Name:</strong>
                        <p id="s_fullname" class="text-muted"></p>
                    </div>

                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p id="s_email" class="text-muted"></p>
                    </div>
                    <div class="col-md-4">
                        <strong>Area Code:</strong>
                        <p id="s_area_code" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>College Code:</strong>
                        <p id="s_college_code" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Course Code:</strong>
                        <p id="s_course_code" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Year Level:</strong>
                        <p id="s_year_level" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Enrolled Status:</strong>
                            <p id="s_enroll_status" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Student Status:</strong>
                            <p id="s_status" class="text-muted"></p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary col-md-3" data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


<!-- Edit Student Modal -->
<div class="modal fade" id="EditStudentForm">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <form method="POST" action="{{ url('/update_student') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">

                <div class="modal-header ">
                    <h5 class="modal-title">Edit Student Informations</h5>
                    <button type="button" class="close text-danger" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="card-body  card-info card-outline margin">
                            <div class="row">
                                <h6 class=" text-uppercase font-weight-bold mb-1 col-md-12">
                                    <i class="fas fa-user mr-2"></i>Student Information
                                </h6>
                                <!-- Student Info -->
                                <div class="form-group col-md-9" hidden>
                                    <label>ID</label>
                                    <input type="text" id="e_id" name="e_id" class="form-control" >
                                </div>

                                <div class="form-group col-md-6" >
                                    <label>Student ID</label>
                                    <input type="text" id="e_sid" name="e_sid"
                                        class="form-control" >
                                </div>

                                <div class="form-group col-md-6" >
                                    <label>Role</label>
                                    <select id="e_rid" name="e_rid" class="form-control">
                                        <option value=""></option>
                                        @foreach($roles ?? [] as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" id="e_lname" name="e_lname" class="form-control">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>First Name</label>
                                    <input type="text" id="e_fname" name="e_fname" class="form-control">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" id="e_mname" name="e_mname" class="form-control">
                                </div>

                                <div class="form-group col-md-8">
                                    <label>Full Name</label>
                                    <input type="text" id="e_fullname" name="e_fullname" class="form-control">
                                </div>

                                 <h6 class="text-uppercase font-weight-bold mb-1 col-md-12 mt-2">
                                    <i class="fas fa-envelope mr-2"></i>Contact Information
                                </h6>
                                <div class="form-group col-md-8">
                                    <label>Email</label>
                                    <input type="email" id="e_email" name="e_email" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="card-body  card-info card-outline margi">
                            <div class="row">
                                 <h6 class="text-uppercase font-weight-bold mb-1 col-md-12">
                                    <i class="fas fa-graduation-cap mr-2"></i>Academic Information
                                </h6>
                                <div class="form-group col-md-4">
                                    <label>Program</label>
                                    <select id="e_course_code" name="e_course_code" class="form-control">
                                        <option value=""></option>
                                        @foreach($programs ?? [] as $p)
                                            <option value="{{ $p->id }}">{{ $p->code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Year Level</label>
                                    <select name="e_year_level" id="e_year_level" class="form-control">
                                        <option value="">Select Year Level</option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Student Status</label>
                                    <select id="e_student_status" name="e_student_status" class="form-control">
                                        <option value="New" selected>New</option>
                                        <option value="Old">Old</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Enrolled</label>
                                    <select id="e_enroll_status" name="e_enroll_status" class="form-control">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex" style="gap: 10px;">
                    <button type="button" class="btn btn-outline-secondary col-md-2 shadow" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-warning col-md-3 shadow">
                        <span class="fas fa-save"></span> Update
                    </button>
                </div>
            </div> <!-- /.modal-content -->
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<!-- Delete Student Modal -->
<div class="modal fade" id="DeleteStudentForm">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Delete Student</h5>
                <button type="button" class="close text-danger" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ url('/delete_student') }}">
                @csrf
                <div class="modal-body text-center mt-3">
                    <input id="da_id" name="d_id" hidden>

                        <h5 class="text-danger ">This action cannot be undone.</h5>
                        <div id="delete_message">
                        </div>
                </div>

                <div class="modal-footer d-flex" style="gap: 10px;">
                    <button type="button" class="btn btn-outline-secondary col-md-2 shadow" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger col-md-3 shadow">
                        <span class="fas fa-trash"></span> Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons-text-hover-effect.css') }}">
<style>
    #searchSuggestions {
        max-height: 240px;
        overflow-y: auto;
        box-shadow: 0 0.75rem 1.25rem rgba(0, 0, 0, 0.12);
    }
    .search-suggestion-item {
        cursor: pointer;
        transition: background-color .15s ease;
    }
    .search-suggestion-item:hover {
        background-color: #f8f9fa;
    }
</style>

@stop

@section('js')


<script src="{{ asset('js/custom.js') }}"></script>

<!-- Import Students CSV: client-side validation, preview, and secure submit -->
<script src="{{asset('js/import-students.js')}}">

</script>

<script>
$(document).ready(function(){
    // Populate course and year level filters
    let courses = new Set();
    let yearLevels = new Set();
    $('#student tbody tr').each(function(){
        let course = $(this).find('td').eq(4).text().trim();
        let year = $(this).find('td').eq(5).text().trim();
        if (course) courses.add(course);
        if (year) yearLevels.add(year);
    });
    courses.forEach(course => {
        $('#filter-course').append(`<option value="${course}">${course}</option>`);
    });
    yearLevels.forEach(year => {
        $('#filter-year').append(`<option value="${year}">${year}</option>`);
    });

    // Function to apply filters and sort
    function applyFiltersAndSort(){
        let filterCourse = $('#filter-course').val();
        let filterYear = $('#filter-year').val();
        let filterEnroll = $('#filter-enroll').val();
        let filterStatus = $('#filter-status').val();
        let sortOrder = $('#sort-order').val();
        let searchQuery = $('#searchTableInput').val().trim().toLowerCase();

        let rows = $('#student tbody tr').toArray();

        // Filter rows
        rows.forEach(row => {
            let $row = $(row);
            let course = $row.find('td').eq(4).text().trim();
            let year = $row.find('td').eq(5).text().trim();
            let enrollRaw = $row.find('td').eq(6).text().trim();
            let enroll = enrollRaw === '1' ? 'Active' : 'Inactive';
            let status = $row.find('td').eq(7).text().trim();
            let sid = $row.find('td').eq(1).text().trim().toLowerCase();
            let fullname = $row.find('td').eq(2).text().trim().toLowerCase();

            let show = true;
            if (filterCourse && course !== filterCourse) show = false;
            if (filterYear && year !== filterYear) show = false;
            if (filterEnroll && enroll !== filterEnroll) show = false;
            if (filterStatus && status !== filterStatus) show = false;
            if (searchQuery && !(sid.startsWith(searchQuery) || fullname.startsWith(searchQuery))) show = false;

            $row.toggle(show);
        });

        // Sort visible rows
        if (sortOrder !== 'none') {
            let visibleRows = rows.filter(row => $(row).is(':visible'));
            visibleRows.sort((a, b) => {
                let nameA = $(a).find('td').eq(2).text().trim().toLowerCase();
                let nameB = $(b).find('td').eq(2).text().trim().toLowerCase();
                if (sortOrder === 'az') {
                    return nameA.localeCompare(nameB);
                } else {
                    return nameB.localeCompare(nameA);
                }
            });
            $('#student tbody').append(visibleRows);
        }
    }

    // Bind change events
    $('#filter-course, #filter-year, #filter-enroll, #filter-status, #sort-order').on('change', applyFiltersAndSort);
    $('#searchTableBtn').on('click', applyFiltersAndSort);
    $('#searchTableInput').on('input', function() {
        updateSearchSuggestions();
    });
    $('#searchTableInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            applyFiltersAndSort();
            hideSearchSuggestions();
        }
    });

    $(document).on('click', '.search-suggestion-item', function() {
        const value = $(this).data('value');
        $('#searchTableInput').val(value);
        applyFiltersAndSort();
        hideSearchSuggestions();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#searchTableInput, #searchSuggestions').length) {
            hideSearchSuggestions();
        }
    });

    function updateSearchSuggestions() {
        const query = $('#searchTableInput').val().trim().toLowerCase();
        if (query.length < 2) {
            hideSearchSuggestions();
            return;
        }

        let matches = [];
        $('#student tbody tr').each(function() {
            const sid = $(this).find('td').eq(1).text().trim();
            const fullname = $(this).find('td').eq(2).text().trim();
            if (sid.toLowerCase().startsWith(query) || fullname.toLowerCase().startsWith(query)) {
                matches.push({ value: fullname, label: `${fullname} — ${sid}` });
            }
        });

        if (!matches.length) {
            hideSearchSuggestions();
            return;
        }

        const suggestionHtml = matches.slice(0, 6).map(item => `
            <button type="button" class="list-group-item list-group-item-action search-suggestion-item" data-value="${item.value}">
                ${item.label}
            </button>
        `).join('');

        $('#searchSuggestions').html(suggestionHtml).removeClass('d-none');
    }

    function hideSearchSuggestions() {
        $('#searchSuggestions').addClass('d-none').empty();
    }
});
</script>

<script>
    $(document).on('click', '.edit-student-modal', function(e) {
        e.preventDefault();

        // Get data from button
        var id = $(this).data('id');
        var rid = $(this).data('rid');
        var sid = $(this).data('sid');
        var lname = $(this).data('lname');
        var fname = $(this).data('fname');
        var mname = $(this).data('mname');
        var fullname = $(this).data('fullname');
        var email = $(this).data('email');
        var areaCode = $(this).data('area_code');
        var collegeCode = $(this).data('college_code');
        var courseProgram = $(this).data('course_program');
        var courseCode = $(this).data('course_code');
        var yearLevel = $(this).data('year_level');
        var term = $(this).data('term');
        var sy = $(this).data('sy');
        var student_status = $(this).data('student_status');
        var enroll_status = $(this).data('enroll_status');

        // Populate modal fields
        $('#e_id').val($(this).data('id'));
        $('#e_rid').val($(this).data('rid'));
        $('#e_sid').val($(this).data('sid'));
        $('#e_lname').val($(this).data('lname'));
        $('#e_fname').val($(this).data('fname'));
        $('#e_mname').val($(this).data('mname'));
        $('#e_fullname').val($(this).data('fullname'));
        $('#e_email').val($(this).data('email'));
        $('#e_area_code').val($(this).data('area_code'));
        $('#e_college_code').val($(this).data('college_code'));
        $('#e_course_code').val($(this).data('course_code'));
        $('#e_year_level').val($(this).data('year_level'));
        $('#e_term').val($(this).data('term'));
        $('#e_sy').val($(this).data('sy'));
        $('#e_student_status').val($(this).data('student_status'));
        $('#e_enroll_status').val($(this).data('enroll_status') == 1 ? 'Active' : 'Inactive');
        // Show Modal
        $('#EditStudentForm').modal('show');
    });

    $('#e_fname, #e_lname').on('keyup', function() {
    var fname = $('#e_fname').val();
    var lname = $('#e_lname').val();

    $('#e_fullname').val(fname + ' ' + lname);
});
</script>

<script>

$('.view-modal-record').on('click', function () {

    let s = $(this).data('student');

    $('#v_student_id').text($(this).data('id'));
    $('#s_lname').text($(this).data('lname'));
    $('#s_fname').text($(this).data('fname'));
    $('#s_mname').text($(this).data('mname'));
    $('#s_fullname').text($(this).data('fullname'));
    $('#s_email').text($(this).data('email'));
    $('#s_address').text($(this).data('address'));
    $('#s_area_code').text($(this).data('area_code'));
    $('#s_college_code').text($(this).data('college_code'));
    $('#s_course_code').text($(this).data('course_code'));
    $('#s_year_level').text($(this).data('year_level'));
    $('#s_term').text($(this).data('term'));
    $('#s_sy').text($(this).data('sy'));
    $('#s_enroll_status').text($(this).data('enroll_status'));
    $('#s_status').text($(this).data('status'));

    $('#ViewStudentModal').modal('show');

});
</script>
<script>
   $(document).on('click', '.delete-modal-record', function() {
        $('.modal-title').text('Delete Student Record');
        $('#da_id').val($(this).data('id'))
        $('#delete_message').html(
            `<p>Do you want to delete this student:<br><strong>${$(this).data('fullname')}</strong>?</p>`
        );
        $('#DeleteForm').modal('show');

    });
</script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
