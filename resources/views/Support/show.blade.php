@extends('adminlte::page')
@section('title', 'Ticket')
@section('content_header')
    <h1 class="mt-3">Support Ticket</h1>
@stop
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <h4>{{ $ticket->subject }}</h4>
        <p class="text-muted">Status: <strong>{{ ucfirst($ticket->status) }}</strong> • Created {{ $ticket->created_at->diffForHumans() }}</p>
        <div class="border rounded p-3 mb-3">{{ $ticket->message }}</div>

        <h5>Messages</h5>
        @foreach($ticket->messages as $msg)
            <div class="mb-2">
                <div><strong>{{ optional($msg->user)->name ?? 'System/User' }}</strong> <small class="text-muted">• {{ $msg->created_at->diffForHumans() }}</small></div>
                <div class="border rounded p-2">{{ $msg->message }}</div>
            </div>
        @endforeach

        <hr>

        <form method="POST" action="{{ route('support.reply', $ticket->id) }}">
            @csrf
            <div class="form-group">
                <label>Your message</label>
                <textarea name="message" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group d-flex" style="gap:8px">
                <button class="btn btn-primary">Send Reply</button>
                <form method="POST" action="{{ route('support.close', $ticket->id) }}">@csrf<button class="btn btn-outline-secondary">Close Ticket</button></form>
                <a href="{{ route('support.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

@stop
