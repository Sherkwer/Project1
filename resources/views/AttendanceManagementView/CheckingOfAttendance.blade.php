@extends('adminlte::page')
@section('title', 'Attendance Management')
@section('content_header')
    <h1 class="mt-3">Checking of Attendance</h1>
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item active" style="cursor: pointer;"> <a href="{{route('home')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" style="cursor: pointer;"> <a href="{{route('AttendanceManagement_pagination')}}">Attendance Management</a></li>
        <li class="breadcrumb-item " style="cursor: pointer;">Checking of Attendance</li>
    </ol>
    {{-- search bar --}}
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
<div class="container-fluid">

    <div class="row">
        <div class="card col-12 mb-3 shadow">
            <div class="card-body row">
                <!-- LEFT PANEL -->
                <div class="col-md-6">

                    <div class="card card-success card-outline shadow h-100">
                        {{-- EVENT DETAILS --}}
                            <div class="card-body">
                                <!-- EVENT NAME -->
                                <div class="mb-3">
                                    <label>Event Name</label>
                                    <input type="text" class="form-control" readonly id="eventName">
                                    <input type="hidden" id="selectedEventId" value="">
                                </div>

                                <!-- DETAILS -->
                                <div class="row ">
                                    <div class="col-md-6">
                                        <label>Schedule</label>
                                        <input type="text" class="form-control" readonly id="eventSchedule">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Fee per-session</label>
                                        <input type="text" class="form-control" readonly id="eventFee">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label>Attendance Date</label>
                                        <input type="date" class="form-control" id="attendanceDate" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <!-- SESSION TABLE -->
                                <div class="card mt-2">
                                    <div class="card-header">
                                        <h5 class="mb-0">Attendance Sessions</h5>
                                    </div>

                                    <div class="card-body p-0">
                                        <table class="table table-bordered text-center mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Session</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sessionTable">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <!-- IMPORT -->
                            <div class="card-footer justify-content-end d-flex">
                                <button class="btn btn-success w-50" id="importStudentListBtn" data-toggle="modal" data-target="#importAttendanceModal">
                                    Import Student List
                                </button>
                            </div>
                    </div>

                </div>

                <!-- RIGHT PANEL -->
                <div class="col-md-6">
                    <div class="card card-success card-outline shadow h-100">
                            <div class="card-body">
                                <h5 class="mb-3">Student QR Code & RFID Preview / Logs</h5>
                                <div id="importedDataContainer" class="table-responsive" style="max-height:360px; overflow:auto;">
                                    <div class="text-muted">No imported data yet.</div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end" style="gap: 20px">
                <button class="btn btn-outline-secondary col-md-2">Cancel</button>
                <button class="btn btn-success col-md-3" id="saveAttendanceBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Attendance Modal -->
<div class="modal fade" id="importAttendanceModal">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <form id="importAttendanceForm" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Modal Header -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title">Import Student Attendance</h5>
                    <button type="button" class="close text-danger" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Select CSV / XLSX file</label>
                        <input type="file" name="file" id="importFileInput" accept=".csv, .xlsx, .xls" class="form-control" />
                        <small class="form-text text-muted mt-2">
                            Select a .csv or .xlsx file. A preview will appear below before importing.
                        </small>
                    </div>

                    <div id="importPreviewContainer" class="mt-3 table-responsive" style="max-height: 400px; overflow:auto;"></div>
                </div>

                <!-- Modal Footer -->
                    <div class="modal-footer">
                    <button type="button" id="importCancelBtn" class="btn btn-outline-secondary" >
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success" >
                        <i class="fas fa-upload"></i> Import
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
<link rel="stylesheet" href="{{asset('css/card_statistics.css') }}">
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
    /* Large circular checkboxes */
    #sessionTable input[type="checkbox"] {
        width: 24px;
        height: 24px;
        cursor: pointer;
        accent-color: #28a745;
    }
    /* Import preview table borders */
    .import-preview-table {
        border-collapse: collapse;
        width: 100%;
    }
    .import-preview-table th,
    .import-preview-table td {
        border: 1px solid #dee2e6;
        padding: .45rem;
        vertical-align: top;
    }
    .import-preview-table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
</style>

@stop

@section('js')
<script>
var events = @json($events);
</script>
<script>
    /**
     * OPTIONAL: Toggle session status
     */
    document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', function() {

            let statusCell = this.children[1];

            if(statusCell.innerText === 'Closed'){
                statusCell.innerHTML = '<span class="badge bg-success">Open</span>';
            } else if(statusCell.innerText === 'Open'){
                statusCell.innerHTML = '<span class="badge bg-danger">Closed</span>';
            }
        });
    });
</script>
<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script>
function populateEvent(event) {
    document.getElementById('eventName').value = event.event_name;
    document.getElementById('eventSchedule').value = event.schedule;
    document.getElementById('eventFee').value = event.fee_perSession;
    // store selected event id for saving
    const sel = document.getElementById('selectedEventId'); if(sel) sel.value = event.id;
    let tbody = document.getElementById('sessionTable');
    tbody.innerHTML = `
        <tr>
            <td>AM In</td>
            <td>${event.am_in === 'A' ? '<input type="checkbox">' : 'N/A'}</td>
        </tr>
        <tr>
            <td>AM Out</td>
            <td>${event.am_out === 'A' ? '<input type="checkbox">' : 'N/A'}</td>
        </tr>
        <tr>
            <td>PM In</td>
            <td>${event.pm_in === 'A' ? '<input type="checkbox">' : 'N/A'}</td>
        </tr>
        <tr>
            <td>PM Out</td>
            <td>${event.pm_out === 'A' ? '<input type="checkbox">' : 'N/A'}</td>
        </tr>
    `;
}

function updateSearchSuggestions() {
    const query = $('#searchTableInput').val().trim().toLowerCase();
    if (query.length < 2) {
        hideSearchSuggestions();
        return;
    }
    let matches = [];
    events.forEach(event => {
        if (event.event_name.toLowerCase().includes(query)) {
            matches.push({ value: event.event_name, event: event });
        }
    });
    if (!matches.length) {
        hideSearchSuggestions();
        return;
    }
    const suggestionHtml = matches.slice(0, 6).map(item => `
        <button type="button" class="list-group-item list-group-item-action search-suggestion-item" data-event='${JSON.stringify(item.event)}'>
            ${item.value}
        </button>
    `).join('');
    $('#searchSuggestions').html(suggestionHtml).removeClass('d-none');
}

function hideSearchSuggestions() {
    $('#searchSuggestions').addClass('d-none').empty();
}

$(document).ready(function(){
    $('#searchTableInput').on('input', function() {
        updateSearchSuggestions();
    });
    $('#searchTableInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const query = $(this).val().trim().toLowerCase();
            const event = events.find(e => e.event_name.toLowerCase() === query);
            if (event) {
                populateEvent(event);
            }
            hideSearchSuggestions();
        }
    });
    $(document).on('click', '.search-suggestion-item', function() {
        const event = $(this).data('event');
        $('#searchTableInput').val(event.event_name);
        populateEvent(event);
        hideSearchSuggestions();
    });
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#searchTableInput, #searchSuggestions').length) {
            hideSearchSuggestions();
        }
    });
});
</script>

<!-- Client-side CSV/XLSX parsing libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.2/papaparse.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const fileInput = document.getElementById('importFileInput');
    if(!fileInput) return;
    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect(e){
        const file = e.target.files[0];
        const container = document.getElementById('importPreviewContainer');
        container.innerHTML = '<div class="text-muted">Reading file...</div>';
        if(!file){ container.innerHTML = ''; return; }
        const ext = file.name.split('.').pop().toLowerCase();
        if(ext === 'csv'){
            Papa.parse(file, {
                header: true,
                skipEmptyLines: true,
                complete: function(results){
                    const fields = (results.meta && results.meta.fields && results.meta.fields.length) ? results.meta.fields : Object.keys(results.data[0] || {});
                    renderPreviewTable(fields, results.data);
                },
                error: function(err){
                    container.innerHTML = '<div class="text-danger">Error reading CSV: '+err.message+'</div>';
                }
            });
        } else if(ext === 'xlsx' || ext === 'xls'){
            const reader = new FileReader();
            reader.onload = function(ev){
                const data = new Uint8Array(ev.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const json = XLSX.utils.sheet_to_json(worksheet, {defval: ''});
                const fields = Object.keys(json[0] || {});
                renderPreviewTable(fields, json);
            };
            reader.onerror = function(){
                container.innerHTML = '<div class="text-danger">Error reading file</div>';
            };
            reader.readAsArrayBuffer(file);
        } else {
            container.innerHTML = '<div class="text-warning">Unsupported file type. Use .csv or .xlsx</div>';
        }
    }

    // Build HTML for the preview table (returns string)
    function renderPreviewHtml(fields, rows){
        if(!rows || rows.length === 0) return '<div class="text-muted">No data found in file.</div>';
        // Normalize fields
        let f = Array.isArray(fields) ? fields.slice() : (rows.length ? Object.keys(rows[0]) : []);
        f = f.map(x => String(x || '').trim());

        // Ensure QR Code header exists
        const hasQR = f.some(h => h && h.toLowerCase().replace(/\s+/g,'').includes('qr'));
        if(!hasQR){
            f.unshift('QR Code');
            // ensure each row has QR Code property (empty string)
            rows = rows.map(r => {
                if(r && typeof r === 'object' && !Array.isArray(r)){
                    if(!('QR Code' in r)) r['QR Code'] = '';
                    return r;
                }
                // convert array row to object mapping
                const obj = {};
                for(let i=0;i<f.length;i++) obj[f[i]] = (Array.isArray(r) ? (r[i] !== undefined ? r[i] : '') : (r[f[i]] !== undefined ? r[f[i]] : ''));
                return obj;
            });
        }

        let html = '<table class="table import-preview-table table-sm"><thead><tr>';
        f.forEach(field => html += '<th>'+escapeHtml(field)+'</th>');
        html += '</tr></thead><tbody>';
        rows.forEach(row=>{
            html += '<tr>';
            f.forEach(field=>{
                const val = (row && (row[field] !== undefined)) ? row[field] : '';
                html += '<td>'+escapeHtml(String(val))+'</td>';
            });
            html += '</tr>';
        });
        html += '</tbody></table>';
        return html;
    }

    function renderPreviewTable(fields, rows){
        const container = document.getElementById('importPreviewContainer');
        if(!rows || rows.length === 0){ container.innerHTML = '<div class="text-muted">No data found in file.</div>'; window.lastImportPreview = null; return; }
        const html = renderPreviewHtml(fields, rows);
        container.innerHTML = html;
        // store last parsed preview data for later use (e.g., moving to right panel)
        window.lastImportPreview = { fields: Array.isArray(fields) ? fields.slice() : Object.keys(rows[0] || {}), rows: JSON.parse(JSON.stringify(rows)) };
    }

    function escapeHtml(text){
        if(text === null || text === undefined) return '';
        return String(text).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('\"','&quot;').replaceAll("'",'&#039;');
    }

    // Clear preview on Cancel button click
    const cancelBtn = document.getElementById('importCancelBtn');
    if(cancelBtn){
        cancelBtn.addEventListener('click', function(){
            const container = document.getElementById('importPreviewContainer');
            if(container) container.innerHTML = '';
            const input = document.getElementById('importFileInput');
            if(input) input.value = '';
        });
    }

    // Also clear preview when modal is fully hidden (covers X and backdrop)
    if(window.jQuery){
        $('#importAttendanceModal').on('hidden.bs.modal', function(){
            $('#importPreviewContainer').empty();
            $('#importFileInput').val('');
        });
    }

    // When the import form is submitted, render the preview into the right panel
    const importForm = document.getElementById('importAttendanceForm');
    if(importForm){
        importForm.addEventListener('submit', function(e){
            e.preventDefault();
            const right = document.getElementById('importedDataContainer');
            if(!right) return;
            if(window.lastImportPreview && window.lastImportPreview.fields && window.lastImportPreview.rows){
                right.innerHTML = renderPreviewHtml(window.lastImportPreview.fields, window.lastImportPreview.rows);
            } else {
                const previewEl = document.getElementById('importPreviewContainer');
                right.innerHTML = previewEl ? previewEl.innerHTML : '<div class="text-muted">No preview available</div>';
            }

            // Attempt to close modal: support Bootstrap 4 (jQuery), Bootstrap 5, and fallback cleanup
            try {
                // Bootstrap 4 via jQuery plugin
                if(window.jQuery && window.jQuery.fn && typeof window.jQuery.fn.modal === 'function'){
                    $('#importAttendanceModal').modal('hide');
                }
                // Bootstrap 5 via bootstrap.Modal
                else if(window.bootstrap && typeof window.bootstrap.Modal === 'function'){
                    const modalEl = document.getElementById('importAttendanceModal');
                    let modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if(!modalInstance) modalInstance = new bootstrap.Modal(modalEl);
                    modalInstance.hide();
                }
                // Fallback DOM cleanup
                else {
                    const modalEl = document.getElementById('importAttendanceModal');
                    if(modalEl){
                        modalEl.classList.remove('show');
                        modalEl.style.display = 'none';
                        modalEl.setAttribute('aria-hidden', 'true');
                        modalEl.removeAttribute('aria-modal');
                        modalEl.removeAttribute('role');
                    }
                    document.body.classList.remove('modal-open');
                    // remove backdrop(s)
                    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                    // remove potential scrollbar padding
                    document.body.style.removeProperty('padding-right');
                    // trigger hidden event if jQuery exists
                    if(window.jQuery && modalEl) $(modalEl).trigger('hidden.bs.modal');
                }
            } catch(err){
                console.warn('Could not programmatically hide modal:', err);
                // attempt fallback hide anyway
                const modalEl = document.getElementById('importAttendanceModal');
                if(modalEl){ modalEl.classList.remove('show'); modalEl.style.display = 'none'; }
                document.body.classList.remove('modal-open');
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }

            // clear modal preview/input
            const preview = document.getElementById('importPreviewContainer'); if(preview) preview.innerHTML = '';
            const input = document.getElementById('importFileInput'); if(input) input.value = '';
        });
    }

});
</script>

<!-- Save attendance (send imported rows to server) -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    const saveBtn = document.getElementById('saveAttendanceBtn');
    if(!saveBtn) return;
    const storeUrl = '{{ route('store_attendance') }}';

    saveBtn.addEventListener('click', async function(e){
        e.preventDefault();
        const selectedEventEl = document.getElementById('selectedEventId');
        const selectedEventId = selectedEventEl ? selectedEventEl.value : '';
        if(!selectedEventId){ alert('Please select an event before saving.'); return; }
        const attendanceDateEl = document.getElementById('attendanceDate');
        const attendanceDate = attendanceDateEl ? attendanceDateEl.value : '';

        function parseTable(containerId){
            const container = document.getElementById(containerId);
            if(!container) return [];
            const table = container.querySelector('table');
            if(!table) return [];
            const headers = Array.from(table.querySelectorAll('thead th')).map(th=>th.innerText.trim());
            const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr=>{
                const tds = Array.from(tr.querySelectorAll('td'));
                const obj = {};
                headers.forEach((h, idx)=> obj[h] = (tds[idx] ? tds[idx].innerText.trim() : ''));
                return obj;
            });
            return rows;
        }

        let rows = parseTable('importedDataContainer');
        if(!rows.length) rows = parseTable('importPreviewContainer');
        if(!rows.length){ alert('No imported data found to save. Please import a file first.'); return; }

        // Build payload and include only session fields when checkbox exists AND is checked
        const fees = document.getElementById('eventFee') ? document.getElementById('eventFee').value : null;

        const sessionRows = document.querySelectorAll('#sessionTable tr');
        const payload = {
            event_id: selectedEventId,
            attendance_date: attendanceDate,
            fees: fees,
            rows: rows
        };

        sessionRows.forEach(tr => {
            const name = tr.children[0] ? tr.children[0].innerText.trim().toLowerCase() : '';
            const cb = tr.querySelector('input[type="checkbox"]');
            // If checkbox is not present, omit this field (do not alter DB)
            if (!cb) return;
            if (name.includes('am in') && cb.checked) payload.am_in = 1;
            if (name.includes('am out') && cb.checked) payload.am_out = 1;
            if (name.includes('pm in') && cb.checked) payload.pm_in = 1;
            if (name.includes('pm out') && cb.checked) payload.pm_out = 1;
        });

        const tokenEl = document.querySelector('#importAttendanceForm input[name="_token"]');
        const token = tokenEl ? tokenEl.value : (document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '');

        try{
            const res = await fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if(res.ok && data.success){
                alert(data.message || 'Attendance saved successfully.');
                location.reload();
            } else {
                alert('Save failed: ' + (data.message || JSON.stringify(data)));
            }
        } catch(err){
            console.error(err);
            alert('Error saving attendance: ' + err.message);
        }
    });
});
</script>

@stop


