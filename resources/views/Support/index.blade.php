@extends('adminlte::page')
@section('title', 'Support Center')
@section('content_header')
    <h1 class="mt-3">Support Center</h1>
    <p class="text-muted">Submit a ticket and track your requests</p>
@stop
@section('content')

<div class="mb-3">
    <a class="btn btn-primary" href="{{ route('support.create') }}">Create Ticket</a>
</div>

<div class="card">
    <div class="card-body">
        @if($tickets->count())
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td><a href="{{ route('support.show', $ticket->id) }}">{{ $ticket->subject }}</a></td>
                        <td>{{ ucfirst($ticket->status) }}</td>
                        <td>{{ $ticket->created_at->diffForHumans() }}</td>
                        <td><a class="btn btn-sm btn-outline-secondary" href="{{ route('support.show', $ticket->id) }}">Open</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $tickets->links() }}
        @else
            <p class="text-muted">No support tickets yet. Create one to get help.</p>
        @endif
    </div>
</div>

@stop
