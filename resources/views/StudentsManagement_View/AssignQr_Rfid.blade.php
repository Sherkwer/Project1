@extends('adminlte::page')

@section('title', 'Assign QR & RFID')

@section('content_header')
    <h1>Student Assignment</h1>
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item active"> <a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{route('StudentsManagement_pagination')}}">Student Management</a></li>
        <li class="breadcrumb-item">Assign QR & RFID</li>
    </ol>
@stop

@section('css')
<style>
    #searchContainer {
        position: relative;
    }

    #searchSuggestions {
        position: absolute;
        top: calc(100% + .5rem);
        left: 0;
        right: 0;
        z-index: 1050;
        max-height: 240px;
        overflow-y: auto;
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12);
    }

    .suggestion-item {
        cursor: pointer;
        transition: background-color .15s ease;
    }

    .suggestion-item:hover {
        background-color: #f3f6fb;
    }

    .student-card {
        background: #ffffff;
        border: 1px solid rgba(0, 123, 255, 0.18);
        border-radius: 1rem;
    }

    .student-card .label-name,
    .student-card .label-id {
        font-size: .95rem;
        letter-spacing: .02em;
        text-transform: uppercase;
        color: #3b5bdb;
    }

    .student-card .value-text {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .alert-success.animate-success {
        animation: pop-in 0.35s ease-out;
    }

    @keyframes pop-in {
        0% { transform: scale(0.95); opacity: 0; }
        60% { transform: scale(1.02); opacity: 1; }
        100% { transform: scale(1); }
    }
</style>
@stop

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-body">

            <!-- TOP SEARCH -->
            <div class="d-flex justify-content-end mb-4">
                <div id="searchContainer" class="w-100 w-md-auto">
                    <div class="input-group shadow-sm" >
                        <input type="text" class="form-control" id="searchInput" placeholder="Type name or student ID" >
                        <button class="btn btn-outline-secondary" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="searchSuggestions" class="list-group mt-2 d-none"></div>
                    <div id="searchHint" class="small text-muted mt-2">
                        Try typing a student name or ID. Click the suggestion to load details instantly.
                    </div>
                </div>
            </div>

            <!-- STUDENT INFO -->
            <div class="row align-items-center mb-4 student-card" id="studentInfo">

                <!-- Avatar -->
                <div class="col-md-3 text-center">
                    <i class="fas fa-user-circle fa-8x text-primary"></i>
                </div>

                <!-- Details -->
                <div class="col-md-9">
                    <h4 class="mb-2">
                        <span class="label-name">Full Name:</span>
                        <div class="value-text" id="student_name">Search to load student</div>
                    </h4>

                    <h5>
                        <span class="label-id">ID:</span>
                        <div class="value-text" id="student_id">---</div>
                    </h5>
                    <input type="hidden" id="student_id_hidden">
                </div>

            </div>

            <!-- INPUTS -->
            <div class="row g-3 mb-4" id="assignmentForm" style="display: none;">

                <!-- QR -->
                <div class="col-md-6">
                    <label class="form-label">Assign QR Code</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="qr_code">
                        <span class="input-group-text">
                            <i class="fas fa-qrcode"></i>
                        </span>
                    </div>
                </div>

                <!-- RFID -->
                <div class="col-md-6">
                    <label class="form-label">Assign RFID</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="rfid">
                        <span class="input-group-text">
                            <i class="fas fa-id-card"></i>
                        </span>
                    </div>
                </div>

            </div>

            <!-- BUTTONS -->
            <div class="d-flex justify-content-end" style="gap: 20px;" id="actionButtons" style="display: none;">

                <button class="btn btn-outline-secondary col-md-1 shadow" id="cancelBtn">
                    Cancel
                </button>

                <button class="btn btn-success col-md-2 shadow" id="saveBtn">
                    Save
                </button>

            </div>

            <!-- ALERTS -->
            <div id="alertContainer"></div>

        </div>
    </div>

</div>

@stop

@section('js')
<script>
$(document).ready(function() {

    // Search on Enter key
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            performSearch();
        }
    });

    // Search on button click
    $('#searchBtn').on('click', function() {
        performSearch();
    });

    // Cancel button
    $('#cancelBtn').on('click', function() {
        resetForm();
    });

    // Save button
    $('#saveBtn').on('click', function() {
        assignQrRfid();
    });

    let suggestionTimer = null;

    $('#searchInput').on('input', function() {
        const query = $(this).val().trim();
        if (query.length < 1) {  // Changed from 2 to 1
            hideSuggestion();
            return;
        }

        clearTimeout(suggestionTimer);
        suggestionTimer = setTimeout(function() {
            fetchSuggestion(query);
        }, 250);
    });

    function performSearch() {
        const query = $('#searchInput').val().trim();
        if (!query) {
            showAlert('Please enter a search term.', 'warning');
            return;
        }

        fetchSuggestion(query, true);
    }

    function fetchSuggestion(query, autoSelect = false) {
        $.ajax({
            url: '{{ route("search_students") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                query: query
            },
            success: function(response) {
                if (response.success && response.students && response.students.length > 0) {
                    showSuggestions(response.students);
                    if (autoSelect && response.students.length === 1) {
                        displayStudent(response.students[0]);
                        hideSuggestion();
                    }
                } else {
                    hideSuggestion();
                    if (autoSelect) {
                        showAlert('No student found with that name or ID.', 'info');
                        resetForm();
                    }
                }
            },
            error: function() {
                hideSuggestion();
                if (autoSelect) {
                    showAlert('An error occurred while searching.', 'danger');
                }
            }
        });
    }

    function showSuggestions(students) {
        let suggestionsHtml = '';
        students.forEach(student => {
            suggestionsHtml += `
                <button type="button" class="list-group-item list-group-item-action suggestion-item" data-student-id="${student.id}">
                    <div class="fw-semibold">${student.fullname}</div>
                    <div class="small text-muted">ID: ${student.sid} | Email: ${student.email}</div>
                </button>
            `;
        });

        $('#searchSuggestions').html(suggestionsHtml).removeClass('d-none');
        $('#searchSuggestions').off('click').on('click', '.suggestion-item', function() {
            const selectedStudentId = $(this).data('student-id');
            const selectedStudent = students.find(s => s.id === selectedStudentId);
            $('#searchInput').val(selectedStudent.fullname);
            displayStudent(selectedStudent);
            hideSuggestion();
        });
    }

    function hideSuggestion() {
        $('#searchSuggestions').addClass('d-none').empty();
    }

    function displayStudent(student) {
        $('#student_name').text(student.fullname);
        $('#student_id').text(student.sid);
        $('#student_id_hidden').val(student.id);

        // Show the sections
        $('#studentInfo').show();
        $('#assignmentForm').show();
        $('#actionButtons').show();

        // Clear previous values
        $('#qr_code').val('');
        $('#rfid').val('');
    }

    function assignQrRfid() {
        const studentId = $('#student_id_hidden').val();
        const searchValue = $('#searchInput').val().trim();
        const qrCode = $('#qr_code').val().trim();
        const rfid = $('#rfid').val().trim();

        if (!searchValue || !studentId) {
            showAlert('Please search for a student first.', 'warning');
            return;
        }

        if (!qrCode && !rfid) {
            showAlert('Please enter at least a QR Code or RFID.', 'warning');
            return;
        }

        $.ajax({
            url: '{{ route("assign_qr_rfid") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                student_id: studentId,
                qr_code: qrCode,
                rfid: rfid
            },
            success: function(response) {
                if (response.success) {
                    showAlert('QR Code and/or RFID assigned successfully!', 'success');
                    resetForm();
                } else {
                    showAlert('Failed to assign. Please try again.', 'danger');
                }
            },
            error: function() {
                showAlert('An error occurred while assigning.', 'danger');
            }
        });
    }

    function resetForm() {
        $('#assignmentForm').hide();
        $('#actionButtons').hide();
        $('#searchInput').val('');
        hideSuggestion();
        $('#qr_code').val('');
        $('#rfid').val('');
        $('#student_name').text('Search to load student');
        $('#student_id').text('---');
        $('#student_id_hidden').val('');
        $('#alertContainer').empty();
    }

    function showAlert(message, type) {
        const animationClass = type === 'success' ? 'animate-success' : '';
        const alertHtml = `
            <div class="alert alert-${type} ${animationClass} alert-dismissible fade show" role="alert">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('#alertContainer').html(alertHtml);
    }

});
</script>
@stop
