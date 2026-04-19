@extends('adminlte::page')
@section('title', 'Event Setting')
@section('content_header')
    <h1 class="mt-3">Event Setting</h1>
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Event Setting</li>
    </ol>
@stop
@section('content')

    <div class="row">
        {{-- Event Stats --}}
        <div class="container-fluid">
            {{-- Small boxes for displaying statistics --}}
            <!-- SUMMARY CARDS -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ count($event) }}</h2>
                            <a class="text-muted">Event Counts</a>
                            <h4 class="fas fa-users text-success float-right"></h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" hidden>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ count($event->where('am_in', 'A')) }}</h2>
                            <a class="text-muted "></a>
                            <h4 class="fas fa-user-plus text-danger float-right"></h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ optional($event->where('status', 'C')->last())->event_name ?? 'N/A' }}</h2>
                            <a class="text-muted">Last Event held</a>
                            <h4 class="fas fa-user-graduate text-primary float-right"></h4>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        {{-- Event Table --}}
        <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-header ">
            <h3 class="card-title">Fixed Header Table</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-success btn-md add-modal-record"   data-toggle="modal" data-target="#AddEventForm">
                        <i class="fas fa-plus"></i> Add New Event
                    </button>
            </div>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap" id="event">
                <thead>
                <tr>
                    <th  hidden>Event ID</th>
                    <th >Event Name</th>
                    <th >Schedule</th>
                    <th >Description</th>
                    <th >AM In</th>
                    <th >AM Out</th>
                    <th >PM In</th>
                    <th >PM Out</th>
                    <th >Fees</th>
                    <th >Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($event as $e)
                <tr>
                    <td hidden>{{$e->id}}</td>
                    <td >{{$e->event_name}}</td>
                    <td >{{$e->schedule}}</td>
                    <td >{{$e->description}}</td>
                    <td >
                        <span class="badge {{ $e->am_in == 'A' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $e->am_in == 'A' ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td >
                        <span class="badge {{ $e->am_out == 'A' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $e->am_out == 'A' ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td >
                        <span class="badge {{ $e->pm_in == 'A' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $e->pm_in == 'A' ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td >
                        <span class="badge {{ $e->pm_out == 'A' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $e->pm_out == 'A' ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td >{{$e->fee_perSession}}</td>

                    <td class="btn-groups">
                            <a href="#" class="view-modal-record btn btn-info view-btn shadow"
                                data-id="{{$e->id}}"
                                data-event_name="{{$e->event_name}}"
                                data-schedule="{{$e->schedule}}"
                                data-sy="{{$e->sy}}"
                                data-term="{{$e->term}}"
                                data-venue="{{$e->venue ?? 'N/A'}}"
                                data-am_in="{{$e->am_in}}"
                                data-am_out="{{$e->am_out}}"
                                data-pm_in="{{$e->pm_in}}"
                                data-pm_out="{{$e->pm_out}}"
                                data-fee="{{$e->fee_perSession}}"
                                data-status="{{$e->status}}"
                                data-description="{{$e->description ?? 'N/A'}}"
                                data-toggle="modal" data-target="#ViewEventModal">
                                <span class="fas fa-eye"></span>
                            </a>

                            <a href="#" class="edit-modal-record btn btn-warning edit-btn shadow"
                            data-id="{{$e->id}}"
                            data-event_name="{{$e->event_name}}"
                            data-schedule="{{$e->schedule}}"
                            data-sy="{{$e->sy}}"
                            data-term="{{$e->term}}"
                            data-venue="{{$e->venue}}"
                            data-am_in="{{$e->am_in}}"
                            data-am_out="{{$e->am_out}}"
                            data-pm_in="{{$e->pm_in}}"
                            data-pm_out="{{$e->pm_out}}"
                            data-fee="{{$e->fee_perSession}}"
                            data-status="{{$e->status ?? ''}}"
                            data-description="{{$e->description}}"
                            data-toggle="modal" data-target="#EditEventForm">
                                <span class="fas fa-edit"></span>
                            </a>

                            <a href="#" class="delete-modal-record btn btn-danger delete-btn shadow"
                                data-id="{{$e->id}}"
                                data-toggle="modal" data-target="#DeleteEventForm">
                                <span class="fas fa-trash"></span>
                            </a>
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

<!-- ADD EVENT MODAL -->
<div class="modal fade" id="AddEventForm" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow">

      <!-- HEADER -->
      <div class="modal-header bg-success">
        <h5 class="fw-semibold">Add New Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="eventForm" method="post" action="{{url('/store_event')}}">
        @csrf

        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

          <!-- EVENT INFORMATION -->
          <h6 class="fw-bold text-primary mb-3">Event Information</h6>
          <div class="row g-3 mb-4">

            <div class="col-md-6" hidden>
              <label class="form-label" >Event ID</label>
              <input type="text" id="e_id" name="e_id" class="form-control" >
            </div>

            <div class="col-md-6">
              <label class="form-label">Event Name</label>
              <input type="text" id="e_event_name" name="e_event_name" class="form-control" required>
            </div>

            <div class="col-6">
              <label class="form-label">Venue</label>
              <input type="text" id="e_venue" name="e_venue" class="form-control" required>
            </div>

          </div>

          <!-- SCHEDULE -->
          <h6 class="fw-bold text-primary mb-3">Schedule & Academic Term</h6>
          <div class="row g-3 mb-4">

            <div class="col-md-4">
              <label class="form-label">Schedule</label>
              <input type="date" id="e_schedule" name="e_schedule" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">School Year</label>
              <input type="text" id="e_sy" name="e_sy" class="form-control" placeholder="2025-2026" required>
            </div>

            <div class="form-group col-md-4">
              <label>Term</label>
              <select id="e_term" name="e_term" class="form-control" required>
                <option>1st Term</option>
                <option>2nd Term</option>
                <option>Summer</option>
              </select>
            </div>

          </div>

          <!-- SESSION STATUS (CHECKBOX VERSION) -->
          <h6 class="fw-bold text-primary mb-3">Session Availability</h6>
          <div class="row g-3 mb-4">

            <!-- Hidden defaults (N/A if not checked) -->
            <input type="hidden" id="hidden_am_in" name="e_am_in" value="N/A">
            <input type="hidden" id="hidden_am_out" name="e_am_out" value="N/A">
            <input type="hidden" id="hidden_pm_in" name="e_pm_in" value="N/A">
            <input type="hidden" id="hidden_pm_out" name="e_pm_out" value="N/A">

            <div class="col-md-6">
              <div class="border rounded p-3">
                <label class="fw-semibold mb-2">Morning Session</label>
                    <div class="row g-2">
                        <div class="col">
                                <div class="form-check form-switch">
                                    <input class="form-check-input session-checkbox"
                                        type="checkbox"
                                        id="checkbox_am_in"

                                        data-target="hidden_am_in"
                                        value="A">
                                    <label class="form-check-label">AM In</label>
                                </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-switch">
                                <input class="form-check-input session-checkbox"
                                    type="checkbox"
                                    id="checkbox_am_out"
                                    data-target="hidden_am_out"
                                    value="A">
                                <label class="form-check-label">AM Out</label>
                            </div>
                        </div>
                    </div>
              </div>
            </div>

             <div class="col-md-6">
              <div class="border rounded p-3">
                <label class="fw-semibold mb-2">Afternoon Session</label>
                <div class="row g-2">
                  <div class="col">
                    <div class="form-check form-switch">
                      <input class="form-check-input session-checkbox"
                             type="checkbox"
                             id="checkbox_pm_in"
                             data-target="hidden_pm_in"
                             value="A">
                      <label class="form-check-label">PM In</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check form-switch">
                      <input class="form-check-input session-checkbox"
                             type="checkbox"
                             id="checkbox_pm_out"
                             data-target="hidden_pm_out"
                             value="A">
                      <label class="form-check-label">PM Out</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- PAYMENT & STATUS -->
          <h6 class="fw-bold text-primary mb-3">Payment & Status</h6>
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Fee Per Session</label>
              <div class="input-group">
                <span class="input-group-text">₱</span>
                <input type="number" step="0.01"
                       id="e_fee_perSession"
                       name="e_fee_perSession"
                       class="form-control"
                       value="{{ $attendanceFee ? '₱' . number_format($attendanceFee->amount, 2) : 'N/A' }}"
                       placeholder="{{ $attendanceFee ? '₱' . number_format($attendanceFee->amount, 2) : 'N/A' }}">

              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="form-label">Status</label>
              <select id="e_status" name="e_status" class="form-control" required>
                <option value="A">Active</option>
                <option value="I">Inactive</option>
                <option value="O">Ongoing</option>
                <option value="C">Completed</option>
                <option value="X">Cancelled</option>
                <option value="P">Postponed</option>
                <option value="R">Rescheduled</option>
              </select>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea id="e_description"
                        name="e_description"
                        rows="3"
                        class="form-control"
                        placeholder="Enter event description...">
                </textarea>
            </div>
          </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer bg-light">
          <button type="reset" class="btn btn-outline-secondary" id="cancelBtn" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-success px-4">
            Save Event
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Event Modal -->
<div class="modal fade" id="ViewEventModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5>View Event Details</h5>
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

<!-- Edit Event Modal -->
<div class="modal fade" class=" modal-dialog modal-dialog-scrollable modal-lg" id="EditEventForm">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <form method="POST" action="{{ url('/update_event') }}">
            @csrf
            @method('POST')
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
                            <input type="text" name="edit_e_id" id="edit_e_id"
                                   class="form-control" >
                        </div>

                        <!-- Event Name -->
                        <div class="col-md-8">
                            <label><strong>Event Name</strong></label>
                            <input type="text" name="edit_e_event_name" id="edit_e_event_name"
                                   class="form-control" required>
                        </div>

                        <!-- Schedule -->
                        <div class="col-md-4">
                            <label><strong>Schedule</strong></label>
                            <input type="text" name="edit_e_schedule" id="edit_e_schedule"
                                   class="form-control" required>
                        </div>

                        <!-- School Year -->
                        <div class="col-md-4">
                            <label><strong>School Year</strong></label>
                            <input type="text" name="edit_e_sy" id="edit_e_sy"
                                   class="form-control" required>
                        </div>

                        <!-- Term -->
                        <div class="col-md-4">
                            <label><strong>Term</strong></label>
                            <input type="text" name="edit_e_term" id="edit_e_term"
                                   class="form-control" required>
                        </div>

                        <!-- Venue -->
                        <div class="col-md-6">
                            <label><strong>Venue</strong></label>
                            <input type="text" name="edit_e_venue" id="edit_e_venue"
                                   class="form-control">
                        </div>

                        <!-- Session Checkboxes -->
                        <div class="col-md-12 mt-3">
                            <label><strong>Session Availability</strong></label>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input session-checkbox"
                                               id="e_am_in"
                                               data-target="hidden-am-in"
                                               value="A">
                                        <label class="form-check-label">AM In</label>
                                        <input type="hidden" name="edit_e_am_in" id="hidden-am-in" value="N/A">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input session-checkbox"
                                               id="e_am_out"
                                               data-target="hidden-am-out"
                                               value="A">
                                        <label class="form-check-label">AM Out</label>
                                        <input type="hidden" name="edit_e_am_out" id="hidden-am-out" value="N/A">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input session-checkbox"
                                               id="e_pm_in"
                                               data-target="hidden-pm-in"
                                               value="A">
                                        <label class="form-check-label">PM In</label>
                                        <input type="hidden" name="edit_e_pm_in" id="hidden-pm-in" value="N/A">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input session-checkbox"
                                               id="e_pm_out"
                                               data-target="hidden-pm-out"
                                               value="A">
                                        <label class="form-check-label">PM Out</label>
                                        <input type="hidden" name="edit_e_pm_out" id="hidden-pm-out" value="N/A">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Fee -->
                        <div class="col-md-4 mt-3">
                            <label><strong>Fee Per Session</strong></label>
                            <input type="number" step="0.01"
                                   name="edit_e_fee_perSession"
                                   id="edit_e_fee_perSession"
                                   class="form-control">
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mt-3">
                            <label><strong>Status</strong></label>
                            <select name="edit_status" id="edit_status" class="form-control">
                                <option value="A">Active</option>
                                <option value="I">Inactive</option>
                                <option value="O">Ongoing</option>
                                <option value="C">Completed</option>
                                <option value="X">Cancelled</option>
                                <option value="P">Postponed</option>
                                <option value="R">Rescheduled</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mt-3">
                            <label><strong>Description</strong></label>
                            <textarea name="edit_e_description"
                                      id="edit_description"
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

{{-- Delete Event Modal --}}
<div class="modal fade" id="DeleteEventForm">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Delete Event</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ url('/delete_event') }}">
                @csrf
                <div class="modal-body text-center">
                    <input id="da_id" name="da_id" hidden>

                    <p class="text-danger">
                        Are you sure you want to delete this event?
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
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/buttons-text-hover-effect.css') }}">

    <link rel="stylesheet" href="{{asset('css/card_statistics.css') }}">
@stop

@section('js')

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
            return value === 'A' ? 'Active' :
            value === 'I' ? 'Inactive' :
            value === 'O' ? 'Ongoing' :
            value === 'C' ? 'Completed' :
            value === 'X' ? 'Cancelled' :
            value === 'P' ? 'Postponed' :
            value === 'R' ? 'Rescheduled' :
            'N/A';
        }

        // Function to display status
        function getStatusDisplay(value) {
            return value === 'A' ? 'Active' :
            value === 'I' ? 'Inactive' :
            value === 'O' ? 'Ongoing' :
            value === 'C' ? 'Completed' :
            value === 'X' ? 'Cancelled' :
            value === 'P' ? 'Postponed' :
            value === 'R' ? 'Rescheduled' :
            'N/A';
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


<script src="{{ asset('js/EventSetting/AddEvent.js') }}"></script>

<script>
    $(document).on('click', '.delete-modal-record', function() {
            $('.modal-title').text('Remove Record');
            $('#delete_message').html('<p>Do you want to remove this record with the title <strong>' + ' - ' + $(this).data('title') + '</strong>?</p>');
           $('#da_id').val($(this).data('id'))
            $('#DeleteEventForm').modal('show');

        });

</script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
