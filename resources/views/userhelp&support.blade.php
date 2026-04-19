@extends('adminlte::page')
@section('title', 'System Support')
@section('content_header')
    <h1 class="mt-3">Help & Support</h1>
    <p class="text-muted">Find answers, troubleshooting steps, and submit support tickets.</p>
@stop
@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <h4>How can we help you?</h4>
                <p class="lead">Use the resources below for quick self-help </p>

                <{{-- div class="mb-3">
                    <a href="{{ route('support.create') }}" class="btn btn-primary">Submit a Support Ticket</a>
                    <a href="{{ route('support.index') }}" class="btn btn-outline-secondary">View Your Tickets</a>
                </> --}}

                <h5 class="mt-4">Frequently Asked Questions</h5>
                <div class="mt-2">
                    <h6>1. How do I reset my password?</h6>
                    <p class="text-muted">Use the "Forgot password" link on the login page and follow the instructions. If that fails, submit a ticke````t with your account email.</p>

                    <h6>2. How do I report a QR code scanning issue?</h6>
                    <p class="text-muted">Include the event name, timestamp, device model, and a screenshot (if available) when submitting a ticket.</p>

                    <h6>3. How can I request role or account changes?</h6>
                    <p class="text-muted">Role changes must be approved by an Administrator. Submit a ticket and include the requested role and justification.</p>
                </div>

                <h5 class="mt-4">Quick Troubleshooting</h5>
                <ul>
                    <li>Clear browser cache and cookies, then reload the page.</li>
                    <li>Try an incognito/private browser window to rule out extensions.</li>
                    <li>Ensure you are using a supported browser (Chrome, Edge, Firefox).</li>
                    <li>Check network connectivity and retry heavy actions when on a stable connection.</li>
                </ul>

                <h5 class="mt-4">Reporting Guidelines</h5>
                <p class="text-muted">When filing a ticket, please include:</p>
                <ul>
                    <li>Detailed steps to reproduce the issue.</li>
                    <li>What you expected to happen versus what happened.</li>
                    <li>Screenshots or screen recordings.</li>
                    <li>Your account name/email and the approximate time of the problem.</li>
                    <li>Browser name/version and device (mobile/desktop).</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Support Hours & Response</strong></div>
            <div class="card-body">
                <p class="text-muted mb-1">Support hours: Mon–Fri, 9:00 AM — 5:00 PM (local time)</p>
                <p class="text-muted mb-0">Typical response time: within 48 business hours. Critical issues will be prioritized.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><strong>Contact</strong></div>
            <div class="card-body">
                <p class="mb-1">For urgent matters, email: <strong>support@ifsu.example.com</strong></p>
                <p class="mb-1">Or submit a ticket using the button above — it's the fastest way to get help.</p>
                <hr>
                <p class="small text-muted mb-1">Useful links</p>
                <ul class="small">
                    <li><a href="{{ route('welcome') }}">Landing / Role Selection</a></li>
                    <li><a href="{{ route('usersLogin') }}">Staff / Admin Login</a></li>
                    <li><a href="{{ route('studentLogin') }}">Student Login</a></li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Documentation</strong></div>
            <div class="card-body">
                <p class="text-muted">See the project README or internal user guide for step-by-step workflows.</p>
                <a href="{{ asset('README.md') }}" class="btn btn-outline-primary btn-sm">Open README</a>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <style>.lead { font-size:1rem; }</style>
@stop

@section('js')
<!-- THis code is for showing record from the table  -->
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
