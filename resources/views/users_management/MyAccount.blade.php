@extends('adminlte::page')
@section('title', 'My Account')
@section('content_header')
    <h1>My Account</h1>
@stop
@section('content')

{{-- table for Students List--}}
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">My Account</h3>
            <div class="card-tools">
                {{-- <button type="button" class="btn btn-success btn-sm add-modal-record"
                        data-toggle="modal" data-target="#AddStudentForm">
                    <i class="fas fa-plus"></i> Add New
                </button> --}}
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="student">
                <thead>
                    <tr>
                        <th hidden>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Campus ID</th>
                        <th>College ID</th>
                        <th>Role ID</th>
                        <th style="width:160px">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myaccount as $m)
                    <tr>
                        <td hidden>{{ $m->id }}</td>
                        <td>{{ $m->fullname }}</td>
                        <td>{{ $m->email }}</td>
                        <td>{{ $m->area_code }}</td>
                        <td>{{ $m->department_id}}</td>
                        <td>{{ $m->rid}}</td>
                        <td>
                            <div class="btn-group-horizontal">

                                <a href="#"
                                    class="btn btn-primary view-modal-record"
                                    data-toggle="modal"
                                    data-target="#ViewStudentModal"
                                    data-id="{{ $m->id }}"
                                    data-lname="{{ $m->lname }}"
                                    data-fname="{{ $m->fname }}">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="#" class="btn btn-info edit-modal-record"
                                   data-id="{{ $m->id }}"
                                   data-toggle="modal" data-target="#EditStudentForm">
                                    <span class="fas fa-edit"></span>
                                </a>

                                <a href="#" class="btn btn-danger delete-modal-record"
                                    data-toggle="modal" data-target="#DeleteStudentForm"
                                    data-id="{{ $m->id }}"
                                    data-name="{{ $m->fullname }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add Student Form/Modal
<div class="modal fade" id="AddStudentForm">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

            </div>

            <form method="POST" action="{{ url('/store_student') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-4">
                            <label>Student ID</label>
                            <input type="text" name="s_student_id" class="form-control">
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

                        <div class="form-group col-md-8">
                            <label>Full Name</label>
                            <input type="text" name="s_fullname" class="form-control">
                        </div>



                        <div class="form-group col-md-4">
                            <label>Sex</label>
                            <select name="s_sex" class="form-control">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label>Email</label>
                            <input type="email" name="s_email" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Campus</label>
                            <select name="s_campus" class="form-control">
                                <option value="IFSU 101">Main</option>
                                <option value="IFSU 102">Lagawe</option>
                                <option value="IFSU 103">Potia</option>
                                <option value="IFSU 104">Tinoc</option>
                                <option value="IFSU 105">Aguinaldo</option>
                                <option value="IFSU 106">Hapao</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>College Code</label>
                            <select name="s_college_code" class="form-control">
                                <option value="16">CCS</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Program</label>
                            <select name="s_course_code" class="form-control">
                                <option value="BSIT">BSIT</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Year Level</label>
                            <select name="s_year_level" class="form-control">
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Term</label>
                            <input type="text" name="s_term" class="form-control">
                            <select name="s_term" class="form-control">
                                <option value="1">1st Term</option>
                                <option value="2">2nd Term</option>
                                <option value="3">3rd Term</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>School Year</label>
                            <select name="s_sy" class="form-control">
                                <option value="2020-2021">2020-2021</option>
                                <option value="2021-2022">2021-2022</option>
                                <option value="2022-2023">2022-2023</option>
                                <option value="2023-2024">2023-2024</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select name="s_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <span class="fas fa-check"></span> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>--}}

<!-- View Student Modal -->
<div class="modal fade" id="ViewStudentModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

                <div class="modal-header bg-info">
                    <h5>Student Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>


            <div class="modal-body">

                <div class="row">

                    <div class="col-md-4">
                        <strong>Student ID:</strong>
                        <p id="v_student_id" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Last Name:</strong>
                        <p id="v_lname" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>First Name:</strong>
                        <p id="v_fname" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Middle Name:</strong>
                        <p id="v_mname" class="text-muted"></p>
                    </div>

                    <div class="col-md-8">
                        <strong>Full Name:</strong>
                        <p id="v_fullname" class="text-muted"></p>
                    </div>

                    <div class="col-md-3">
                        <strong>Age:</strong>
                        <p id="v_age" class="text-muted"></p>
                    </div>

                    <div class="col-md-3">
                        <strong>Sex:</strong>
                        <p id="v_sex" class="text-muted"></p>
                    </div>

                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p id="v_email" class="text-muted"></p>
                    </div>

                    <div class="col-md-12">
                        <strong>Address:</strong>
                        <p id="v_address" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Area Code:</strong>
                        <p id="v_area_code" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>College Code:</strong>
                        <p id="v_college_code" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Course Code:</strong>
                        <p id="v_course_code" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Year Level:</strong>
                        <p id="v_year_level" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Term:</strong>
                        <p id="v_term" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>School Year:</strong>
                        <p id="v_sy" class="text-muted"></p>
                    </div>

                    <div class="col-md-4">
                        <strong>Status:</strong>
                        <p id="v_status" class="text-muted"></p>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


<!-- Edit Student Modal -->
<div class="modal fade" id="EditStudentForm">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Edit Student</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ url('/update_student') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <!-- Student ID -->
                        <div class="form-group col-md-4" hidden>
                            <label>Student ID</label>
                            <input type="text" id="e_student_id" name="s_student_id"
                                   class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" id="e_lname" name="s_lname" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>First Name</label>
                            <input type="text" id="e_fname" name="s_fname" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Middle Name</label>
                            <input type="text" id="e_mname" name="s_mname" class="form-control">
                        </div>

                        <div class="form-group col-md-8">
                            <label>Full Name</label>
                            <input type="text" id="e_fullname" name="s_fullname" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Sex</label>
                            <select id="e_sex" name="s_sex" class="form-control">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label>Email</label>
                            <input type="email" id="e_email" name="s_email" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Area Code</label>
                            <input type="text" id="e_area_code" name="s_area_code" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>College Code</label>
                            <input type="text" id="e_college_code" name="s_college_code" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Course Program</label>
                            <input type="text" id="e_course_program" name="s_course_program" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Course Code</label>
                            <input type="text" id="e_course_code" name="s_course_code" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Year Level</label>
                            <input type="text" id="e_year_level" name="s_year_level" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Term</label>
                            <input type="text" id="e_term" name="s_term" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>School Year</label>
                            <input type="text" id="e_sy" name="s_sy" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select id="e_status" name="s_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">
                        <span class="fas fa-save"></span> Update
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<!-- Delete Student Modal -->
<div class="modal fade" id="DeleteStudentForm">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Delete Student</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ url('/delete_student') }}">
                @csrf
                <div class="modal-body text-center">
                    <input type="hidden" id="d_student_id" name="student_id">

                    <p class="text-danger">
                        Are you sure you want to delete this student?
                    </p>
                    <strong id="d_student_name"></strong>
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
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}


@stop

@section('js')
<!-- THis code is for showing record from the table  -->
<script>

$('.view-modal-record').on('click', function () {

    let s = $(this).data('student');

    $('#v_student_id').text($(this).data('student_id'));
    $('#v_lname').text($(this).data('lname'));
    $('#v_fname').text($(this).data('fname'));
    $('#v_mname').text($(this).data('mname'));
    $('#v_fullname').text($(this).data('fullname'));
    $('#v_age').text($(this).data('age'));
    $('#v_sex').text($(this).data('sex'));
    $('#v_email').text($(this).data('email'));
    $('#v_address').text($(this).data('address'));
    $('#v_area_code').text($(this).data('area_code'));
    $('#v_college_code').text($(this).data('college_code'));
    $('#v_course_code').text($(this).data('course_code'));
    $('#v_year_level').text($(this).data('year_level'));
    $('#v_term').text($(this).data('term'));
    $('#v_sy').text($(this).data('sy'));
    $('#v_status').text($(this).data('status'));

    $('#ViewStudentModal').modal('show');

});
</script>

<script>
        $(document).on('click', '.edit-modal-record', function() {
            $('.modal-title').text('Edit Record');
            $('#ea_id').val($(this).data('id'))
            $('#ea_title').val($(this).data('title'))
            $('#ea_content').val($(this).data('content'))

            $('#EditForm').modal('show');
        });
</script>
<script>
   $(document).on('click', '.delete-modal-record', function() {
            $('.modal-title').text('Remove Record');
            $('#delete_message').html('<p>Do you want to remove this record with the title <strong>' + ' - ' + $(this).data('title') + '</strong>?</p>');
           $('#da_id').val($(this).data('id'))
            $('#DeleteForm').modal('show');

        });
</script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
