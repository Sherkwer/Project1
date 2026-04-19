@extends('adminlte::page')

@section('title', 'Student Profile')

@section('content_header')
    <h1>Student Profile</h1>
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item active"> <a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{route('StudentsManagement_pagination')}}">Student Management</a></li>
        <li class="breadcrumb-item">Student Profile</li>
    </ol>
@stop

@section('content')
<div class="account-cover-banner">
    <div class="account-cover-shape account-cover-shape-1"></div>
    <div class="account-cover-shape account-cover-shape-2"></div>
    <div class="account-cover-shape account-cover-shape-3"></div>
</div>

<div class="my-account-page">
    <div class="account-layout-container">
        <aside class="account-profile-card">
            <div class="account-profile-inner">
                <div class="account-profile-header text-center">
                    <div class="account-avatar-wrapper mx-auto">
                        <img src="{{ asset('images/landing/user1-128x128.jpg') }}"
                             alt="Profile avatar"
                             class="account-avatar-img">
                    </div>

                    <div class="mt-3">
                        <div class="account-profile-name">{{ $student->fullname }}</div>
                        <div class="account-profile-company text-muted">Student ID: {{ $student->sid }}</div>
                        <div class="account-profile-company text-muted">{{ $student->email }}</div>
                    </div>
                </div>

                <div class="account-profile-actions mt-4">
                    <a href="{{ route('StudentsManagement_pagination') }}" class="btn btn-light btn-block account-profile-public-btn">
                        Back to Students
                    </a>

                    <div class="account-profile-url mt-3">
                        <div class="account-profile-stat-row">
                            <span class="account-profile-stat-label">Enrollment Status</span>
                            <span class="account-profile-stat-value text-success">{{ $student->enroll_status == 1 ? 'Active' : 'Inactive' }}</span>
                        </div>
                        <div class="account-profile-divider"></div>
                        <div class="account-profile-stat-row">
                            <span class="account-profile-stat-label">Student Status</span>
                            <span class="account-profile-stat-value text-secondary">{{ $student->student_status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="account-main-panel">
            <div class="card account-main-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mb-0">Student Profile</h4>
                            <small class="text-muted">Record ID: {{ $student->id }}</small>
                        </div>
                        <a href="{{ route('StudentsManagement_pagination') }}" class="btn btn-secondary">Return</a>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="mb-3">Student Details</h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Student ID</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->sid }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Role</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ optional($roles->where('id', $student->rid)->first())->name ?? $student->rid }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Email</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->email }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Last Name</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->lname }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">First Name</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->fname }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Middle Name</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->mname }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Campus</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ optional($areas->where('area_code', $student->area_code)->first())->area_name ?? $student->area_code }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">College</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ optional($colleges->where('id', $student->college_code)->first())->name ?? $student->college_code }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Organization</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ optional($organizations->where('id', $student->organization_id)->first())->name ?? ($student->organization_id ? 'Organization #' . $student->organization_id : 'N/A') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Course</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ optional($programs->where('id', $student->course_code)->first())->name ?? optional($programs->where('code', $student->course_code)->first())->name ?? $student->course_code }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">QR Code</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->qr_code }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">RFID</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->rfid }}">
                                        </div>

                                        <div class="col-md-4 mb-3" >
                                            <label class="account-field-label">Year Level</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->year_level }}">
                                        </div>
                                        <div class="col-md-4 mb-3" hidden>
                                            <label class="account-field-label">Term</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->term }}">
                                        </div>

                                        <div class="col-md-4 mb-3" hidden>
                                            <label class="account-field-label">School Year</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->sy }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Enrollment Status</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->enroll_status == 1 ? 'Active' : 'Inactive' }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="account-field-label">Student Status</label>
                                            <input type="text" readonly class="form-control account-input" value="{{ $student->student_status }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/Profile/profile.css') }}">
@stop

@section('js')
    {{-- Custom JS for profile page could go here if needed --}}
@stop

