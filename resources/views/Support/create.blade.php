@extends('adminlte::page')
@section('title', 'Create Support Ticket')
@section('content_header')
    <h1 class="mt-3">Create Support Ticket</h1>
@stop
@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('support.store') }}">
            @csrf

            <div class="form-group">
                <label>Subject</label>
                <input name="subject" class="form-control" value="{{ old('subject') }}" required>
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="6" required>{{ old('message') }}</textarea>
            </div>

            <div class="form-group">
                <button class="btn btn-primary">Submit Ticket</button>
                <a href="{{ route('support.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@stop
