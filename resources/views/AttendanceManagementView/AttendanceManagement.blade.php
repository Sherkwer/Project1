@extends('adminlte::page')
@section('title', 'Attendance Management')
@section('content_header')
    <h1 class="mt-3">Attendance Management</h1>
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item active" style="cursor: pointer;"><a href="{{ route('home') }}"></a>Dashboard</li>
        <li class="breadcrumb-item " href="#" style="cursor: pointer;">Attendance Management</li>
    </ol>
    <div class="row mb-2 justify-content-end">
        <div class="col-md-6">
            <div class="position-relative">
                <div class="input-group">
                    <input type="text" id="searchTableInput" class="form-control" placeholder="Search by name of Event">
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

<div class="row">
        <div class="container-fluid">
            {{-- Small boxes for displaying statistics --}}
            <!-- SUMMARY CARDS -->
            <div class="row mb-3" >
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body" >
                            {{-- <h2 class="fw-bold">90%</h2>
                            <a class="text-muted">Attendance Rate</a>
                            <h4 class="fas fa-users text-success float-right"></h4> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body" >
                            {{-- <h2 class="fw-bold">200</h2>
                            <a class="text-muted ">Fresh Men</a>
                            <h4 class="fas fa-user-plus text-danger float-right"></h4> --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body" >
                            {{-- <h2 class="fw-bold">300</h2>
                            <a class="text-muted">Previews Students</a>
                            <h4 class="fas fa-user-graduate text-primary float-right"></h4> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Attendance Log Table --}}
    <div class="col-md-12">
        <div class="card-header mb-1" >
            <div class="card-tools">
                <a type="button" class="btn btn-success shadow" href="{{route('/AttendanceManagementView/CheckingOfAttendance')}}" style="width: 200px; border-radius: 7px;">
                    <i class="fas "></i> Checking of Attendance
                </a>

            </div>

        </div>

        <div class="card">
            <div class="card-header ">
                <h4 class="card-title">Students Attendance Records</h4>
                <div class="card-tools" style="display: flex; justify-content: flex-end; width: 1000px;">
                    {{-- <!-- Filters Row -->
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
                    </div> --}}
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-hover" id="attendance">
                    <thead>
                        <tr>
                        <th hidden>Attendance ID</th>
                        <th >Student ID</th>
                        <th >Event ID</th>
                        <th >Date</th>
                        <th >AM In</th>
                        <th >AM Out</th>
                        <th >PM In</th>
                        <th >PM Out</th>
                        <th >Total Fees</th>

                        <th class="col-md-1 text-center" hidden>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendance as $d)
                        <tr>
                        <td hidden>{{$d->attendance_id}}</td>
                            <td>{{$d->student_id}}</td>
                            <td>{{$d->event_id}}</td>
                            <td>{{$d->attendance_date}}</td>
                            <td>
                                @if($d->am_in === null || $d->am_in === '')
                                    <span class="badge badge-secondary">N/A</span>
                                @elseif($d->am_in == '1' || $d->am_in === 1)
                                    <span class="badge badge-success">Present</span>
                                @elseif($d->am_in == '0' || $d->am_in === 0)
                                    <span class="badge badge-danger">Absent</span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($d->am_out === null || $d->am_out === '')
                                    <span class="badge badge-secondary">N/A</span>
                                @elseif($d->am_out == '1' || $d->am_out === 1)
                                    <span class="badge badge-success">Present</span>
                                @elseif($d->am_out == '0' || $d->am_out === 0)
                                    <span class="badge badge-danger">Absent</span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($d->pm_in === null || $d->pm_in === '')
                                    <span class="badge badge-secondary">N/A</span>
                                @elseif($d->pm_in == '1' || $d->pm_in === 1)
                                    <span class="badge badge-success">Present</span>
                                @elseif($d->pm_in == '0' || $d->pm_in === 0)
                                    <span class="badge badge-danger">Absent</span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($d->pm_out === null || $d->pm_out === '')
                                    <span class="badge badge-secondary">N/A</span>
                                @elseif($d->pm_out == '1' || $d->pm_out === 1)
                                    <span class="badge badge-success">Present</span>
                                @elseif($d->pm_out == '0' || $d->pm_out === 0)
                                    <span class="badge badge-danger">Absent</span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>{{$d->fees}}</td>

                            <td class="btn-groups cols-1" hidden>
                                <a href="#" class="btn btn-info view-btn view-modal-record shadow"
                                    data-toggle="modal"
                                    data-target="#ViewStudentModal"
                                        data-sid="{{ $d->sid }}">
                                        <i class="fas fa-eye"> </i>
                                    </a>
                                    <a href="#" class="btn btn-warning edit-btn edit-student-modal  shadow" data-toggle="modal" data-target="#EditStudentForm"
                                        data-id="{{ $d->id }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger delete-btn delete-modal-record shadow"
                                    data-toggle="modal" data-target="#DeleteStudentForm"
                                        data-id="{{ $d->id }}">
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
                    Total: {{ count($attendance) }} records
                </small>
            </div>
        </div>
    </div>

</div>


  <div class="modal fade" id="AddForm" >
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" role="form" method="post" action="{{url('/store_attendance')}}">
             @csrf
        <div class="modal-body">

              <div class="row">

                <!-- Attendance ID -->
                <div class="form-group col-md-6">
                    <label for="a_attendance_id">Attendance ID</label>
                    <input type="text" class="form-control"
                        id="a_attendance_id"
                        name="a_attendance_id"
                        value=""
                        readonly>
                </div>

                <!-- Student ID -->
                <div class="form-group col-md-6">
                    <label for="a_student_id">Student ID</label>
                    <input type="text" class="form-control"
                        id="a_student_id"
                        name="a_student_id"
                        value="">
                </div>

                <!-- Event ID -->
                <div class="form-group col-md-6">
                    <label for="a_event_id">Event ID</label>
                    <input type="text" class="form-control"
                        id="a_event_id"
                        name="a_event_id"
                        value="">
                </div>

                <!-- Attendance Date -->
                <div class="form-group col-md-6">
                    <label for="a_attendance_date">Date</label>
                    <input type="date" class="form-control"
                        id="a_attendance_date"
                        name="a_attendance_date"
                        value="">
                </div>

                <!-- AM In -->
                <div class="form-group col-md-3">
                    <label for="a_am_in">AM In</label>
                    <input type="time" class="form-control"
                        id="a_am_in"
                        name="a_am_in"
                        value="">
                </div>

                <!-- AM Out -->
                <div class="form-group col-md-3">
                    <label for="a_am_out">AM Out</label>
                    <input type="time" class="form-control"
                        id="a_am_out"
                        name="a_am_out"
                        value="">
                </div>

                <!-- PM In -->
                <div class="form-group col-md-3">
                    <label for="a_pm_in">PM In</label>
                    <input type="time" class="form-control"
                        id="a_pm_in"
                        name="a_pm_in"
                        value="">
                </div>

                <!-- PM Out -->
                <div class="form-group col-md-3">
                    <label for="a_pm_out">PM Out</label>
                    <input type="time" class="form-control"
                        id="a_pm_out"
                        name="a_pm_out"
                        value="">
                </div>

                <!-- Fees -->
                <div class="form-group col-md-6">
                    <label for="fees">Fees</label>
                    <input type="number" class="form-control"
                        id="fees"
                        name="fees"
                        value="">
                </div>

                </div>

        </div>
      </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success" ><span id="" class='fas fa-check'></span> Save</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Close</button>
          </div>
                 </form>
        </div>
      </div>

<!-- Edit Event Modal -->
<div class="modal fade" class=" modal-dialog modal-dialog-scrollable modal-lg" id="EditEventModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <form id="EditEventForm" method="POST" action="{{ route('update_event', ['id' => 'PLACEHOLDER']) }}">
            @csrf
            @method('post')
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-info text-dark">
                    <h5>Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Event ID -->
                        <div class="col-md-4">
                            <label><strong>Event ID</strong></label>
                            <input type="text" name="id" id="edit-event-id"
                                   class="form-control" readonly>
                        </div>

                        <!-- Event Name -->
                        <div class="col-md-8">
                            <label><strong>Event Name</strong></label>
                            <input type="text" name="event_name" id="edit-event-name"
                                   class="form-control" required>
                        </div>

                        <!-- Schedule -->
                        <div class="col-md-4">
                            <label><strong>Schedule</strong></label>
                            <input type="text" name="schedule" id="edit-schedule"
                                   class="form-control" required>
                        </div>

                        <!-- School Year -->
                        <div class="col-md-4">
                            <label><strong>School Year</strong></label>
                            <input type="text" name="sy" id="edit-sy"
                                   class="form-control" required>
                        </div>

                        <!-- Term -->
                        <div class="col-md-4">
                            <label><strong>Term</strong></label>
                            <input type="text" name="term" id="edit-term"
                                   class="form-control" required>
                        </div>

                        <!-- Venue -->
                        <div class="col-md-6">
                            <label><strong>Venue</strong></label>
                            <input type="text" name="venue" id="edit-venue"
                                   class="form-control">
                        </div>

                        <!-- Session Checkboxes -->
                        <div class="col-md-12 mt-3">
                            <label><strong>Session Availability</strong></label>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="edit-am-in"
                                               value="A">
                                        <label class="form-check-label">AM In</label>
                                        <input type="hidden" name="am_in" id="hidden-am-in" value="N/A">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="edit-am-out"
                                               value="A">
                                        <label class="form-check-label">AM Out</label>
                                        <input type="hidden" name="am_out" id="hidden-am-out" value="N/A">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="edit-pm-in"
                                               value="A">
                                        <label class="form-check-label">PM In</label>
                                        <input type="hidden" name="pm_in" id="hidden-pm-in" value="N/A">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="edit-pm-out"
                                               value="A">
                                        <label class="form-check-label">PM Out</label>
                                        <input type="hidden" name="pm_out" id="hidden-pm-out" value="N/A">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Fee -->
                        <div class="col-md-4 mt-3">
                            <label><strong>Fee Per Session</strong></label>
                            <input type="number" step="0.01"
                                   name="fee_perSession"
                                   id="edit-fee"
                                   class="form-control">
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mt-3">
                            <label><strong>Status</strong></label>
                            <select name="status" id="edit-status" class="form-control">
                                <option value="A">Active</option>
                                <option value="I">Inactive</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mt-3">
                            <label><strong>Description</strong></label>
                            <textarea name="description"
                                      id="edit-description"
                                      rows="3"
                                      class="form-control"></textarea>
                        </div>

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            id="cancelEditBtn"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-info">
                        Update Event
                    </button>
                </div>
            </div> <!-- /.modal-content -->
        </form>
    </div>
</div>


<!-- View Event Modal -->
<div class="modal fade" id="ViewEventModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5>Event Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <!-- Basic Info -->
                    <div class="col-md-4">
                        <strong>Event ID:</strong>
                        <p class="text-muted" id="view-event-id">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-8">
                        <strong>Event Name:</strong>
                        <p class="text-muted" id="view-event-name">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-4">
                        <strong>Schedule:</strong>
                        <p class="text-muted" id="view-schedule">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-4">
                        <strong>School Year:</strong>
                        <p class="text-muted" id="view-sy">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-4">
                        <strong>Term:</strong>
                        <p class="text-muted" id="view-term">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-6">
                        <strong>Venue:</strong>
                        <p class="text-muted" id="view-venue">
                            N/A
                        </p>
                    </div>

                    <!-- Session Availability -->
                    <div class="col-md-3">
                        <strong>AM In:</strong>
                        <p class="text-muted" id="view-am-in">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-3">
                        <strong>AM Out:</strong>
                        <p class="text-muted" id="view-am-out">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-3">
                        <strong>PM In:</strong>
                        <p class="text-muted" id="view-pm-in">
                            N/A
                        </p>
                    </div>

                    <div class="col-md-3">
                        <strong>PM Out:</strong>
                        <p class="text-muted" id="view-pm-out">
                            N/A
                        </p>
                    </div>

                    <!-- Payment -->
                    <div class="col-md-4">
                        <strong>Fee Per Session:</strong>
                        <p class="text-muted" id="view-fee">
                            ₱ 0.00
                        </p>
                    </div>

                    <div class="col-md-4">
                        <strong>Status:</strong>
                        <p class="text-muted" id="view-status">
                            N/A
                        </p>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <strong>Description:</strong>
                        <p class="text-muted" id="view-description">
                            N/A
                        </p>
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

<!-- Import Attendance CSV Modal -->
<div class="modal fade" id="importAttendanceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Import Student Attendance (CSV)</h5>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <!-- Event Search Section -->
                <div class="form-group">
                    <label for="eventSearchInput"><strong>Search Event</strong></label>
                    <div class="input-group mb-2">
                        <input type="text"
                               class="form-control"
                               id="eventSearchInput"
                               placeholder="Search by Event ID, Name, or Schedule">
                        <div class="input-group-append">
                            <button class="btn btn-primary"
                                    type="button"
                                    id="eventSearchBtn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Selected Event Display -->
                <div id="selectedEventDisplay" style="display: none;" class="alert alert-info mb-3">
                    <strong>Selected Event:</strong>
                    <div class="mt-2">
                        <p class="mb-1"><strong>Event ID:</strong> <span id="displayEventId">-</span></p>
                        <p class="mb-1"><strong>Event Name:</strong> <span id="displayEventName">-</span></p>
                        <p class="mb-0"><strong>Schedule:</strong> <span id="displayEventSchedule">-</span></p>
                        <p class="mb-0"><strong>Fee:</strong> <span id="displayEventFee">-</span></p>
                    </div>
                </div>

                <!-- Event Search Results Modal Trigger -->
                <button type="button"
                        class="btn btn-sm btn-outline-secondary"
                        id="showEventListBtn"
                        data-toggle="modal"
                        data-target="#eventSearchModal"
                        style="display: none;">
                    View Results
                </button>

                <hr>

                <!-- File Input -->
                <div class="form-group">
                    <label for="attendance_csv"><strong>Select CSV File</strong></label>
                    <input type="file"
                           class="form-control"
                           id="attendance_csv"
                           accept=".csv"
                           disabled>
                    <small class="text-muted">
                        Accepted format: .csv
                        Example columns: student_qrcode, student_id, id, attendance_date, am_in, am_out, pm_in, pm_out, fees
                    </small>
                </div>

                <hr>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Preview</h6>
                        <span class="badge badge-primary" id="rowCountBadge">
                            Rows: 0
                        </span>
                    </div>

                <!-- Preview Table Container -->
                <div id="previewContainer" class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Dynamic table will appear here -->
                </div>

                <hr>

                <!-- Validation Results Section -->
                <div id="validationResultsSection" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Validated Student Records</h6>
                        <span class="badge badge-info" id="validatedCountBadge">
                            Valid: 0
                        </span>
                    </div>

                    <!-- Validated Students Table Container -->
                    <div id="validatedStudentsContainer" class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <!-- Validated student records will appear here -->
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">

                <!-- Clear Button (Does NOT close modal) -->
                <button type="button"
                        class="btn btn-danger"
                        id="clearImportBtn">
                    Clear
                </button>

                <button type="button"
                        class="btn btn-success"
                        id="importBtn"
                        disabled>
                    Import
                </button>

            </div>

        </div>
    </div>
</div>

<!-- Event Search Results Modal -->
<div class="modal fade" id="eventSearchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Event Search Results</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div id="eventSearchResults" class="table-responsive">
                    <!-- Event results will appear here -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


        </div>
      </div>
    </div>
  </div>

<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>


@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons-text-hover-effect.css') }}">
<link rel="stylesheet" href="{{asset('css/card_statistics.css') }}">

@stop

@section('js')

<script src="{{ asset('js/custom.js') }}"></script>

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('attendance_csv');
    const previewContainer = document.getElementById('previewContainer');
    const validatedStudentsContainer = document.getElementById('validatedStudentsContainer');
    const validationResultsSection = document.getElementById('validationResultsSection');
    const clearBtn = document.getElementById('clearImportBtn');
    const importBtn = document.getElementById('importBtn');
    const rowCountBadge = document.getElementById('rowCountBadge');
    const validatedCountBadge = document.getElementById('validatedCountBadge');

    // Initial state
    importBtn.disabled = true;

    // When file selected
    fileInput.addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (!file) {
            resetModal();
            return;
        }

        // Validate CSV
        if (file.type !== "text/csv" && !file.name.endsWith('.csv')) {
            alert("Invalid file type. Please upload a CSV file.");
            resetModal();
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {

            const csvData = event.target.result;
            const rows = csvData.split('\n').filter(row => row.trim() !== '');

            if (rows.length === 0) {
                alert("CSV file is empty.");
                resetModal();
                return;
            }

            // Create table
            let table = document.createElement('table');
            table.classList.add('table', 'table-bordered', 'table-striped', 'table-sm');

            // Header
            let thead = document.createElement('thead');
            let headerRow = document.createElement('tr');
            const headers = rows[0].split(',');

            headers.forEach(header => {
                let th = document.createElement('th');
                th.textContent = header.trim();
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Body
            let tbody = document.createElement('tbody');
            let qrcodes = [];

            for (let i = 1; i < rows.length; i++) {
                let row = document.createElement('tr');
                let columns = rows[i].split(',');

                columns.forEach(col => {
                    let td = document.createElement('td');
                    td.textContent = col.trim();
                    row.appendChild(td);
                });

                tbody.appendChild(row);

                // Collect QR codes from first column (assuming QR code is in first column)
                if (columns[0]) {
                    qrcodes.push(columns[0].trim());
                }
            }

            table.appendChild(tbody);

            previewContainer.innerHTML = "";
            previewContainer.appendChild(table);

            // UPDATE ROW COUNT (exclude header row)
            const dataRowCount = rows.length;
            rowCountBadge.textContent = "Rows: " + dataRowCount;

            // NOW VALIDATE QR CODES WITH THE DATABASE
            validateQRCodesWithDatabase(qrcodes);
        };

        reader.readAsText(file);
    });

    // VALIDATE QR CODES WITH DATABASE
    function validateQRCodesWithDatabase(qrcodes) {

        $.ajax({
            url: '{{ route("attendance.validate_import") }}',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                _token: '{{ csrf_token() }}',
                qrcodes: qrcodes
            }),
            success: function(response) {
                if (response.success) {
                    displayValidationResults(response.validatedStudents, response.invalidQrcodes);

                    if (response.invalidCount > 0) {
                        alert(response.invalidCount + ' QR code(s) are invalid and will not be imported.');
                    }

                    if (response.validatedCount > 0) {
                        importBtn.disabled = false;
                    }
                } else {
                    alert(response.message || 'Validation failed.');
                    importBtn.disabled = true;
                }
            },
            error: function(xhr) {
                alert('Error validating QR codes. Please try again.');
                console.error(xhr);
                importBtn.disabled = true;
            }
        });
    }

    // DISPLAY VALIDATION RESULTS
    function displayValidationResults(validatedStudents, invalidQrcodes) {

        // Show validation results section
        validationResultsSection.style.display = 'block';

        if (validatedStudents.length === 0) {
            validatedStudentsContainer.innerHTML = '<div class="alert alert-warning">No valid student records found.</div>';
            validatedCountBadge.textContent = 'Valid: 0';
            return;
        }

        // Create validated students table
        let table = document.createElement('table');
        table.classList.add('table', 'table-bordered', 'table-striped', 'table-sm', 'table-success');

        // Header
        let thead = document.createElement('thead');
        let headerRow = document.createElement('tr');

        const headers = ['Student QR Code', 'Student ID', 'Full Name'];
        headers.forEach(header => {
            let th = document.createElement('th');
            th.textContent = header;
            headerRow.appendChild(th);
        });

        thead.appendChild(headerRow);
        table.appendChild(thead);

        // Body
        let tbody = document.createElement('tbody');

        validatedStudents.forEach(student => {
            let row = document.createElement('tr');

            let qrcodeCell = document.createElement('td');
            qrcodeCell.textContent = student.student_qrcode;
            row.appendChild(qrcodeCell);

            let studentIdCell = document.createElement('td');
            studentIdCell.textContent = student.student_id;
            row.appendChild(studentIdCell);

            let fullnameCell = document.createElement('td');
            fullnameCell.textContent = student.fullname;
            row.appendChild(fullnameCell);

            tbody.appendChild(row);
        });

        table.appendChild(tbody);

        validatedStudentsContainer.innerHTML = "";
        validatedStudentsContainer.appendChild(table);

        // Update badge
        validatedCountBadge.textContent = 'Valid: ' + validatedStudents.length;
    }

    // CLEAR BUTTON FUNCTION
    clearBtn.addEventListener('click', function () {
        resetModal();
    });

    // Reusable Reset Function
    function resetModal() {
        fileInput.value = "";
        previewContainer.innerHTML = "";
        validatedStudentsContainer.innerHTML = "";
        validationResultsSection.style.display = 'none';
        rowCountBadge.textContent = "Rows: 0";
        validatedCountBadge.textContent = "Valid: 0";
        importBtn.disabled = true;
    }

});
</script>

<!-- Event Search and Selection Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const eventSearchInput = document.getElementById('eventSearchInput');
    const eventSearchBtn = document.getElementById('eventSearchBtn');
    const selectedEventDisplay = document.getElementById('selectedEventDisplay');
    const showEventListBtn = document.getElementById('showEventListBtn');
    const eventSearchResults = document.getElementById('eventSearchResults');
    const attendanceFileInput = document.getElementById('attendance_csv');

    let selectedEvent = null;

    // Event Search Button Click
    eventSearchBtn.addEventListener('click', function () {
        const searchQuery = eventSearchInput.value.trim();

        if (!searchQuery) {
            alert('Please enter a search term (Event ID, Name, or Schedule)');
            return;
        }

        // Get all events from the page table
        const allEvents = getEventsFromTable();

        if (allEvents.length === 0) {
            alert('No events found in the system.');
            return;
        }

        // Filter events based on search query
        const filteredEvents = filterEvents(allEvents, searchQuery);

        if (filteredEvents.length === 0) {
            alert('No events found matching your search: ' + searchQuery);
            eventSearchResults.innerHTML = '<div class="alert alert-warning">No results found.</div>';
            showEventListBtn.style.display = 'none';
            return;
        }

        // Display results
        displayEventSearchResults(filteredEvents);
        showEventListBtn.style.display = 'inline-block';

        // Auto-open modal if only one result
        if (filteredEvents.length === 1) {
            $('#eventSearchModal').modal('show');
        }
    });

    // Allow searching on Enter key
    eventSearchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            eventSearchBtn.click();
        }
    });

    // Get all events from the events table
    function getEventsFromTable() {
        const events = [];
        const rows = document.querySelectorAll('#events tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                events.push({
                    event_id: cells[0].textContent.trim(),
                    event_name: cells[1].textContent.trim(),
                    schedule: cells[2].textContent.trim(),
                    am_in: cells[6].textContent.trim(),
                    am_out: cells[7].textContent.trim(),
                    pm_in: cells[8].textContent.trim(),
                    pm_out: cells[9].textContent.trim(),
                    fee: cells[10].textContent.trim()
                });
            }
        });

        return events;
    }

    // Get active sessions for an event
    function getActiveSessions(event) {
        const sessions = [];

        if (event.am_in === 'A') sessions.push('AM In');
        if (event.am_out === 'A') sessions.push('AM Out');
        if (event.pm_in === 'A') sessions.push('PM In');
        if (event.pm_out === 'A') sessions.push('PM Out');

        return sessions;
    }

    // Filter events based on search query
    function filterEvents(events, query) {
        const lowerQuery = query.toLowerCase();

        return events.filter(event =>
            event.event_id.toLowerCase().includes(lowerQuery) ||
            event.event_name.toLowerCase().includes(lowerQuery) ||
            event.schedule.toLowerCase().includes(lowerQuery)
        );
    }

    // Display event search results
    function displayEventSearchResults(events) {
        let html = '<table class="table table-bordered table-hover table-sm">';
        html += '<thead class="bg-light"><tr><th>Event ID</th><th>Event Name</th><th>Schedule</th><th>Active Sessions</th><th>Action</th></tr></thead>';
        html += '<tbody>';

        events.forEach(event => {
            const activeSessions = getActiveSessions(event);
            const sessionsDisplay = activeSessions.length > 0 ? activeSessions.join(', ') : 'No Active Sessions';
            const sessionsClass = activeSessions.length > 0 ? 'badge badge-success' : 'badge badge-warning';

            html += `<tr>
                <td>${event.event_id}</td>
                <td>${event.event_name}</td>
                <td>${event.schedule}</td>
                <td><span class="${sessionsClass}">${sessionsDisplay}</span></td>
                <td>
                    <button class="btn btn-sm btn-success select-event-btn"
                            data-event-id="${event.event_id}"
                            data-event-name="${event.event_name}"
                            data-event-schedule="${event.schedule}"
                            data-am-in="${event.am_in}"
                            data-am-out="${event.am_out}"
                            data-pm-in="${event.pm_in}"
                            data-pm-out="${event.pm_out}">
                        Select
                    </button>
                </td>
            </tr>`;
        });

        html += '</tbody></table>';
        eventSearchResults.innerHTML = html;

        // Attach click handlers to select buttons
        document.querySelectorAll('.select-event-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                selectedEvent = {
                    event_id: this.getAttribute('data-event-id'),
                    event_name: this.getAttribute('data-event-name'),
                    event_schedule: this.getAttribute('data-event-schedule'),
                    am_in: this.getAttribute('data-am-in'),
                    am_out: this.getAttribute('data-am-out'),
                    pm_in: this.getAttribute('data-pm-in'),
                    pm_out: this.getAttribute('data-pm-out')
                };

                // Display selected event
                displaySelectedEvent(selectedEvent);

                // Enable file input
                attendanceFileInput.disabled = false;

                // Close modal
                $('#eventSearchModal').modal('hide');
            });
        });
    }

    // Display selected event info
    function displaySelectedEvent(event) {
        const activeSessions = getActiveSessions(event);
        const sessionsDisplay = activeSessions.length > 0 ? activeSessions.join(', ') : 'No Active Sessions';

        document.getElementById('displayEventId').textContent = event.event_id;
        document.getElementById('displayEventName').textContent = event.event_name;
        document.getElementById('displayEventSchedule').textContent = event.event_schedule;

        // Add active sessions display to the selected event info
        let sessionInfo = document.getElementById('displayEventSessions');
        if (!sessionInfo) {
            const displayDiv = document.getElementById('selectedEventDisplay');
            sessionInfo = document.createElement('p');
            sessionInfo.id = 'displayEventSessions';
            sessionInfo.className = 'mb-0';
            displayDiv.querySelector('.mt-2').appendChild(sessionInfo);
        }
        sessionInfo.innerHTML = '<strong>Active Sessions:</strong> <span class="badge badge-info">' + sessionsDisplay + '</span>';

        selectedEventDisplay.style.display = 'block';
    }

    // Store selected event in window for use in other scripts
    window.selectedEvent = () => selectedEvent;

});
</script>
<script>
    $(document).on('click', '.view-modal-record', function(e) {
        e.preventDefault();

        // Get all data from the clicked button
        var eventId = $(this).data('event_id');
        var eventName = $(this).data('event_name');
        var schedule = $(this).data('schedule');
        var sy = $(this).data('sy');
        var term = $(this).data('term');
        var venue = $(this).data('venue');
        var amIn = $(this).data('am_in');
        var amOut = $(this).data('am_out');
        var pmIn = $(this).data('pm_in');
        var pmOut = $(this).data('pm_out');
        var fee = $(this).data('fee');
        var status = $(this).data('status');
        var description = $(this).data('description');

        // Function to display session status
        function getSessionStatus(value) {
            return value === 'A' ? 'Active' : 'N/A';
        }

        // Function to display status
        function getStatusDisplay(value) {
            return value === 'A' ? 'Active' : 'Inactive';
        }

        // Populate modal with data
        $('#view-event-id').text(eventId);
        $('#view-event-name').text(eventName || 'N/A');
        $('#view-schedule').text(schedule || 'N/A');
        $('#view-sy').text(sy || 'N/A');
        $('#view-term').text(term || 'N/A');
        $('#view-venue').text(venue || 'N/A');
        $('#view-am-in').text(getSessionStatus(amIn));
        $('#view-am-out').text(getSessionStatus(amOut));
        $('#view-pm-in').text(getSessionStatus(pmIn));
        $('#view-pm-out').text(getSessionStatus(pmOut));
        $('#view-fee').text('₱ ' + parseFloat(fee || 0).toFixed(2));
        $('#view-status').text(getStatusDisplay(status));
        $('#view-description').text(description || 'N/A');
    });
</script>

<script>
$(document).on('click', '.edit-modal-record', function(e) {
    e.preventDefault();

    // Get all data from the clicked button
    var eventId = $(this).data('event_id');
    var eventName = $(this).data('event_name');
    var schedule = $(this).data('schedule');
    var sy = $(this).data('sy');
    var term = $(this).data('term');
    var venue = $(this).data('venue');
    var amIn = $(this).data('am_in');
    var amOut = $(this).data('am_out');
    var pmIn = $(this).data('pm_in');
    var pmOut = $(this).data('pm_out');
    var fee = $(this).data('fee');
    var status = $(this).data('status');
    var description = $(this).data('description');

    // Populate modal with data
    $('#edit-event-id').val(eventId);
    $('#edit-event-name').val(eventName);
    $('#edit-schedule').val(schedule);
    $('#edit-sy').val(sy);
    $('#edit-term').val(term);
    $('#edit-venue').val(venue);
    $('#edit-fee').val(fee);
    $('#edit-status').val(status);
    $('#edit-description').val(description);

    // Handle checkboxes for session availability
    function setCheckbox(checkboxId, hiddenId, value) {
        if (value === 'A') {
            $('#' + checkboxId).prop('checked', true);
            $('#' + hiddenId).val('A');
        } else {
            $('#' + checkboxId).prop('checked', false);
            $('#' + hiddenId).val('N/A');
        }
    }

    setCheckbox('edit-am-in', 'hidden-am-in', amIn);
    setCheckbox('edit-am-out', 'hidden-am-out', amOut);
    setCheckbox('edit-pm-in', 'hidden-pm-in', pmIn);
    setCheckbox('edit-pm-out', 'hidden-pm-out', pmOut);

    // Update form action with correct event_id
    var newAction = "{{ route('update_event', ['id' => 'ID_PLACEHOLDER']) }}".replace('ID_PLACEHOLDER', eventId);
    $('#editEventForm').attr('action', newAction);

    // Show Modal
    $('#EditEventModal').modal('show');
});
</script>

<script>
// Handle checkbox changes to update hidden inputs
$(document).on('change', '.form-check-input', function() {
    let hiddenInput = $(this).closest('.form-check').find('input[type="hidden"]');

    if ($(this).is(':checked')) {
        hiddenInput.val('A');
    } else {
        hiddenInput.val('N/A');
    }
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
