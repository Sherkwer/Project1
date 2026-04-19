@extends('adminlte::page')
@section('title', 'Home')
@section('content_header')
    @php
        $user = auth()->user();
        $displayName = $user ? ($user->name ?? $user->username ?? 'User') : 'Guest';
        $roleName = $user ? ($user->getRoleName() ?? 'User') : 'Guest';
        $roleTasks = [
            'Super Administrator' => [
                'Manage Users, Campus, Colleges, Organizations, Programs, Periods and ect.. roles',
                'Configure system settings',
                'View Profile information',
            ],
            'Administrator' => [
                'Manage departments and staff',
                'Approve registrations and requests',
                'Manage events and attendance',
            ],
            'Student' => [
                'Scan QR codes for attendance',
                'View personal attendance records',
                'Register for events',
            ],
            'Staff' => [
                'Manage classes and schedules',
                'Take and verify attendance',
                'Publish announcements and notices',
            ],
        ];
        $tasks = $roleTasks[$roleName] ?? ['Access your dashboard', 'Update your profile', 'View notifications'];
    @endphp

    <h1 class="mt-3">Welcome, {{ $displayName }}</h1>
    <p class="text-muted">Role: <strong>{{ $roleName }}</strong></p>
@stop
@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Getting started</h3>
            </div>
            <div class="card-body">
                <p class="lead">As a <strong>{{ $roleName }}</strong>, here are the common tasks you can perform:</p>
                <ul>
                    @foreach($tasks as $task)
                        <li>{{ $task }}</li>
                    @endforeach
                </ul>
                @if(!$user)
                    <a href="{{ route('usersLogin') }}" class="btn btn-primary">Sign in</a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Quick tips</h3>
            </div>
            <div class="card-body">
                <p>Use the navigation to access features related to your role.</p>
                <p class="mb-0">Need help? <a href="#">Contact support service providers</a></p>
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
