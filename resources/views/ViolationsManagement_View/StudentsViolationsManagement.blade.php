@extends('adminlte::page')
@section('title', 'Violation Setting')
@section('content_header')
    <h1 class="mt-4">Violation Setting</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Violation Setting</li>
    </ol>
@stop
@section('content')

    {{-- This is the code for showing the record from the List of Violations  --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                <h3 class="card-title">List of Students Violations</h3>

                <div class="card-tools">
                    <button style="border-radius: 8px;" type="button" class="btn btn-success btn-md add-modal-record shadow"   data-toggle="modal" data-target="#AddStudentViolationForm">
                            <i class="fas fa-plus"></i> Add New Student Violation
                    </button>

                </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap" id="event">
                    <thead>
                    <tr class="text-wrap">
                        <th hidden>ID</th>
                        <th hidden>Campus </th>
                        <th hidden>College</th>
                        <th hidden>Program</th>
                        <th>Student ID</th>
                        <th>Violation</th>
                        <th>Date</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th class="col-1">Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students_violations as $sv)
                    <tr class="">
                        <td hidden>{{$sv->id}}</td>
                        <td hidden>{{$sv->area_code}}</td>
                        <td hidden>{{$sv->college_id}}</td>
                        <td hidden>{{$sv->course_id}}</td>
                        <td>{{$sv->student_id}}</td>
                        <td>{{$sv->vid}}</td>
                        <td>{{$sv->date_issued}}</td>
                        <td>{{$sv->fee}}</td>
                        <td>{{$sv->status}}</td>

                        <td class="u-buttons" >
                            <div class="d-flex" style="gap:20px; justify-content: center;">
                                <a href="#" class="view-student-violation-modal btn btn-outline-primary rounded-circle shadow"
                                data-id="{{$sv->id}}"
                                data-area_code="{{$sv->area_code}}"
                                data-college_id="{{$sv->college_id}}"
                                data-course_id="{{$sv->course_id}}"
                                data-student_id="{{$sv->student_id}}"
                                data-vid="{{$sv->vid}}"
                                data-date_issued="{{$sv->date_issued}}"
                                data-fee="{{$sv->fee}}"
                                data-status="{{$sv->status}}"
                                data-toggle="modal" data-target="#ViewStudentViolationForm">
                                    <span class="fas fa-eye"></span>
                                </a>

                                <a href="#" class="edit-student-violation-modal btn btn-outline-info rounded-circle shadow"
                                data-id="{{$sv->id}}"
                                data-area_code="{{$sv->area_code}}"
                                data-college_id="{{$sv->college_id}}"
                                data-organization_id="{{$sv->organization_id}}"
                                data-course_id="{{$sv->course_id}}"
                                data-student_id="{{$sv->student_id}}"
                                data-vid="{{$sv->vid}}"
                                data-date_issued="{{$sv->date_issued}}"
                                data-fee="{{$sv->fee}}"
                                data-status="{{$sv->status}}"
                                data-toggle="modal" data-target="#EditStudentViolationForm">
                                    <span class="fas fa-edit"></span>
                                </a>

                                <a href="#" class="delete-student-violation-modal btn btn-outline-danger rounded-circle shadow"
                                    data-id="{{$sv->id}}"
                                    data-student_id="{{$sv->student_id}}"
                                    data-toggle="modal" data-target="#DeleteStudentViolationForm">
                                    <span class="fas fa-trash"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <!-- Add Student Violation Modal -->
    <div class="modal fade" id="AddStudentViolationForm">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <form method="POST" action="{{ url('/store_student_violation') }}">
                @csrf
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Add New Student Violation</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row">

                            <!-- Area Code -->
                            <div class="form-group col-md-6">
                                <label>Campus</label>
                                <input type="text" class="form-control" id="sv_area_code" name="sv_area_code" value="{{ old('sv_area_code', $user->area_code ?? '') }}" readonly required>
                            </div>

                            <!-- College ID -->
                            <div class="form-group col-md-6">
                                <label>College</label>
                                <input type="text" class="form-control" id="sv_college_id_display" value="{{ optional($colleges->where('id', $user->college_id ?? $user->department_id)->first())->name ?? '' }}" readonly>
                                <input type="hidden" id="sv_college_id" name="sv_college_id" value="{{ old('sv_college_id', $user->college_id ?? $user->department_id ?? '') }}">
                            </div>

                            <!-- Organization ID -->
                            <div class="form-group col-md-6">
                                <label>Organization</label>
                                <input type="text" class="form-control" id="sv_organization_id_display" value="{{ $user->organization_id ? 'Organization #'.$user->organization_id : '' }}" readonly>
                                <input type="hidden" id="sv_organization_id" name="sv_organization_id" value="{{ old('sv_organization_id', $user->organization_id ?? '') }}">
                            </div>

                            <!-- Course ID -->
                            <div class="form-group col-md-6">
                                <label>Course ID</label>
                                <input type="text" id="sv_course_id" name="sv_course_id" class="form-control" required>
                            </div>

                            <!-- Student ID -->
                            <div class="form-group col-md-6">
                                <label>Student ID</label>
                                <input type="text" id="sv_student_id" name="sv_student_id" class="form-control" required>
                            </div>

                            <!-- Violation -->
                            <div class="form-group col-md-6">
                                <label>Violation</label>
                                <select id="sv_vid" name="sv_vid" class="form-control" required>
                                    <option value="">Select Violation</option>
                                    @foreach($violations as $v)
                                        <option value="{{$v->id}}">{{$v->vname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Issued -->
                            <div class="form-group col-md-6">
                                <label>Date Issued</label>
                                <input type="date" id="sv_date_issued" name="sv_date_issued" class="form-control" required>
                            </div>

                            <!-- Fee Selection -->
                            <div class="form-group col-md-6">
                                <label>Fee</label>
                                <select id="sv_fee_select" name="sv_fee_select" class="form-control">
                                    <option value="">Select Fee</option>
                                    @foreach($fees as $f)
                                        <option value="{{$f->id}}" data-amount="{{$f->amount}}">{{$f->fee_name}} - ₱{{$f->amount}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fee Amount -->
                            <div class="form-group col-md-6">
                                <label>Fee Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" step="0.01" id="sv_fee" name="sv_fee" class="form-control" readonly>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <span class="fas fa-save"></span> Save
                        </button>
                    </div>

                </div> <!-- /.modal-content -->
            </form>
        </div>
    </div>

    <!-- View Student Violation Modal -->
    <div class="modal fade" id="ViewStudentViolationForm">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">View Student Violation</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Campus</label>
                            <input type="text" class="form-control" id="v_area_code" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>College</label>
                            <input type="text" class="form-control" id="v_college_id" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Course</label>
                            <input type="text" class="form-control" id="v_course_id" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Student ID</label>
                            <input type="text" class="form-control" id="v_student_id" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Violation</label>
                            <input type="text" class="form-control" id="v_vid" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Date Issued</label>
                            <input type="date" class="form-control" id="v_date_issued" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Fee</label>
                            <input type="text" class="form-control" id="v_fee" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <input type="text" class="form-control" id="v_status" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Violation Modal -->
    <div class="modal fade" id="EditStudentViolationForm">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <form method="POST" action="{{ url('/update_student_violation') }}">
                @csrf
                @method('POST')
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <h5 class="modal-title">Edit Student Violation</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <!-- ID -->
                            <div class="form-group col-md-4" hidden>
                                <label for="esv_id">ID</label>
                                <input type="text" id="esv_id" name="esv_id" class="form-control">
                            </div>

                            <!-- Area Code -->
                            <div class="form-group col-md-6">
                                <label for="esv_area_code">Campus</label>
                                <input type="text" class="form-control" id="esv_area_code" name="esv_area_code" readonly required>
                            </div>

                            <!-- College ID -->
                            <div class="form-group col-md-6">
                                <label for="esv_college_id_display">College</label>
                                <input type="text" class="form-control" id="esv_college_id_display" readonly>
                                <input type="hidden" id="esv_college_id" name="esv_college_id">
                            </div>

                            <!-- Organization ID -->
                            <div class="form-group col-md-6">
                                <label for="esv_organization_id_display">Organization</label>
                                <input type="text" class="form-control" id="esv_organization_id_display" readonly>
                                <input type="hidden" id="esv_organization_id" name="esv_organization_id">
                            </div>

                            <!-- Course ID -->
                            <div class="form-group col-md-6">
                                <label for="esv_course_id">Course ID</label>
                                <input type="text" id="esv_course_id" name="esv_course_id" class="form-control" required>
                            </div>

                            <!-- Student ID -->
                            <div class="form-group col-md-6">
                                <label for="esv_student_id">Student ID</label>
                                <input type="text" id="esv_student_id" name="esv_student_id" class="form-control" required>
                            </div>

                            <!-- Violation -->
                            <div class="form-group col-md-6">
                                <label for="esv_vid">Violation</label>
                                <select id="esv_vid" name="esv_vid" class="form-control" required>
                                    <option value="">Select Violation</option>
                                    @foreach($violations as $v)
                                        <option value="{{$v->id}}">{{$v->vname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Issued -->
                            <div class="form-group col-md-6">
                                <label for="esv_date_issued">Date Issued</label>
                                <input type="date" id="esv_date_issued" name="esv_date_issued" class="form-control" required>
                            </div>

                            <!-- Fee Selection -->
                            <div class="form-group col-md-6">
                                <label for="esv_fee_select">Fee</label>
                                <select id="esv_fee_select" name="esv_fee_select" class="form-control">
                                    <option value="">Select Fee</option>
                                    @foreach($fees as $f)
                                        <option value="{{$f->id}}" data-amount="{{$f->amount}}">{{$f->fee_name}} - ₱{{$f->amount}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fee Amount -->
                            <div class="form-group col-md-6">
                                <label for="esv_fee">Fee Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" step="0.01" id="esv_fee" name="esv_fee" class="form-control">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group col-md-6">
                                <label for="esv_status">Status</label>
                                <select id="esv_status" name="esv_status" class="form-control">
                                    <option value="A">Active</option>
                                    <option value="I">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-info">
                            <span class="fas fa-save"></span> Update
                        </button>
                    </div>
                </div> <!-- /.modal-content -->
            </form>
        </div>
    </div>

    {{-- Delete Student Violation Modal --}}
    <div class="modal fade" id="DeleteStudentViolationForm">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Delete Student Violation</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ url('/delete_student_violation') }}">
                    @csrf
                    <div class="modal-body text-center">
                        <input id="dasv_id" name="dasv_id" hidden>

                        <p class="text-danger">
                            Are you sure you want to delete this student violation?
                        </p>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-danger">
                            <span class="fas fa-trash"></span> Delete
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/buttons-text-hover-effect.css') }}">
@stop

@section('js')
<!-- THis code is for showing record from the table  -->
<script>
    // Populate edit modal
    $(document).on('click', '.edit-student-violation-modal', function(e) {
        e.preventDefault();
        var Id = $(this).data('id');
        var AreaCode = $(this).data('area_code');
        var CollegeId = $(this).data('college_id');
        var OrganizationId = $(this).data('organization_id');
        var CourseId = $(this).data('course_id');
        var StudentId = $(this).data('student_id');
        var Vid = $(this).data('vid');
        var DateIssued = $(this).data('date_issued');
        var Fee = $(this).data('fee');
        var Status = $(this).data('status');

        $('#esv_id').val(Id);
        $('#esv_area_code').val('{{ $user->area_code }}');
        $('#esv_college_id_display').val('{{ optional($colleges->where('id', $user->college_id ?? $user->department_id)->first())->name ?? '' }}');
        $('#esv_college_id').val('{{ $user->college_id ?? $user->department_id }}');
        $('#esv_organization_id_display').val('{{ $user->organization_id ? 'Organization #'.$user->organization_id : '' }}');
        $('#esv_organization_id').val('{{ $user->organization_id }}');
        $('#esv_course_id').val(CourseId);
        $('#esv_student_id').val(StudentId);
        $('#esv_vid').val(Vid);
        $('#esv_date_issued').val(DateIssued);
        $('#esv_fee').val(Fee);
        $('#esv_status').val(Status);

        $('#EditStudentViolationForm').modal('show');
    });

    // Populate view modal
    $(document).on('click', '.view-student-violation-modal', function(e) {
        e.preventDefault();
        var AreaCode = $(this).data('area_code');
        var CollegeId = $(this).data('college_id');
        var CourseId = $(this).data('course_id');
        var StudentId = $(this).data('student_id');
        var Vid = $(this).data('vid');
        var DateIssued = $(this).data('date_issued');
        var Fee = $(this).data('fee');
        var Status = $(this).data('status');

        $('#v_area_code').val(AreaCode);
        $('#v_college_id').val(CollegeId);
        $('#v_course_id').val(CourseId);
        $('#v_student_id').val(StudentId);
        $('#v_vid').val(Vid);
        $('#v_date_issued').val(DateIssued);
        $('#v_fee').val('₱'+parseFloat(Fee).toFixed(2));
        $('#v_status').val(Status == 'A' ? 'Active' : 'Inactive');

        $('#ViewStudentViolationForm').modal('show');
    });

    // Populate delete modal
    $(document).on('click', '.delete-student-violation-modal', function() {
        $('.modal-title').text('Delete Student Violation');
        $('#delete_message').html('<p>Do you want to remove this student violation for student <strong>' + $(this).data('student_id') + '</strong>?</p>');
        $('#dasv_id').val($(this).data('id'));
        $('#DeleteStudentViolationForm').modal('show');
    });

    // Fee selection for add modal
    $(document).on('change', '#sv_fee_select', function() {
        var amount = $(this).find(':selected').data('amount');
        $('#sv_fee').val(amount);
    });

    // Fee selection for edit modal
    $(document).on('change', '#esv_fee_select', function() {
        var amount = $(this).find(':selected').data('amount');
        $('#esv_fee').val(amount);
    });
</script>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
