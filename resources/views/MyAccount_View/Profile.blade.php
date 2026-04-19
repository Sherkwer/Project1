@extends('adminlte::page')

@section('title', 'My Account')

@section('content_header')

    {{-- We intentionally leave the default header empty to let the custom cover banner take over --}}
@stop

@section('content')
{{-- Top Cover Banner --}}
    <div class="account-cover-banner">
        <div class="account-cover-shape account-cover-shape-1"></div>
        <div class="account-cover-shape account-cover-shape-2"></div>
        <div class="account-cover-shape account-cover-shape-3"></div>

        <button type="button" class="btn btn-outline-light btn-sm account-cover-change-btn">
            <i class="fas fa-camera mr-1"></i>
            Change Cover
        </button>
    </div>
    <div class="my-account-page">


        <div class="account-layout-container">
            {{-- Left Sidebar Profile Card --}}
            <aside class="account-profile-card">
                <div class="account-profile-inner">
                    {{-- Profile Section --}}
                    <div class="account-profile-header text-center">
                        <div class="account-avatar-wrapper mx-auto">
                            <img src="{{ asset('images/landing/user1-128x128.jpg') }}"
                                 alt="Profile avatar"
                                 class="account-avatar-img">
                            <button type="button" class="account-avatar-edit-btn">
                                <i class="fas fa-upload"></i>
                            </button>
                        </div>
                        <div class="mt-3">
                            <div class="account-profile-name">{{ Auth::user()->rid }}</div>
                            <div class="account-profile-name">{{ Auth::user()->fullname }}</div>
                            <div class="account-profile-company text-muted"> {{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    {{-- Statistics Section --}}

                    <div class="account-profile-stats mt-4">
                        <div class="account-profile-stat-row">
                            <span class="account-profile-stat-label">Account status</span>
                            <span class="account-profile-stat-value text-success">Active</span>
                        </div>
                        <div class="account-profile-divider"></div>
                        <div class="account-profile-stat-row">
                            <span class="account-profile-stat-label">Role</span>
                            <span class="account-profile-stat-value text-success">{{ Auth::user()->user_role }}</span>
                        </div>
                    </div>

                    {{-- Profile Actions --}}
                    <div class="account-profile-actions mt-4">
                        <button type="button" class="btn btn-light btn-block account-profile-public-btn">
                            View Public Profile
                        </button>

                        <div class="account-profile-url mt-3">
                            <label class="account-field-label">Profile URL</label>
                            <div class="input-group input-group-sm">
                                <input type="text"
                                       class="form-control"
                                       value="https://app.ahiregro..."
                                       readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="far fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main Content Panel --}}
            <main class="account-main-panel">
                <div class="card account-main-card">
                    <div class="card-body">
                        {{-- Tabs Navigation --}}
                        <ul class="nav account-tabs-nav mb-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-account-settings" role="tab">
                                    Account Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="javascript:void(0);">
                                    Notifications
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- Account Settings Tab --}}
                            <div class="tab-pane fade show active" id="tab-account-settings" role="tabpanel">
                                <form>
                                    <div class="form-row">
                                        {{-- Row 1 --}}
                                        <div class="form-group col-md-4">
                                            <label class="account-field-label">First Name</label>
                                            <input type="text" class="form-control account-input" value=" {{ Auth::user()->fname }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="account-field-label">Middle Name</label>
                                            <input type="text" class="form-control account-input" value=" {{ Auth::user()->mname }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="account-field-label">Last Name</label>
                                            <input type="text" class="form-control account-input" value="{{ Auth::user()->lname }}">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        {{-- Row 2 --}}
                                        <div class="form-group col-md-8">
                                            <label class="account-field-label">Email address</label>
                                            <input type="email"
                                                   class="form-control account-input"
                                                   value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        {{-- Row 3 --}}
                                        <div class="form-group col-md-6">
                                            <label class="account-field-label">Campus</label>
                                            <input type="text" class="form-control account-input" value="{{ Auth::user()->area_code }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="account-field-label">College</label>
                                            <input type="text" class="form-control account-input" value="{{ Auth::user()->department_id }}">
                                        </div>
                                    </div>
                                    {{-- Action Button --}}
                                    <div class="mt-3">
                                        <button style="width: 150px; border-radius: 10px;" type="submit" class="btn btn-block bg-teal color-palette btn-lg shadow-lg">
                                            <a href="{{route('/MyAccount_Views/UpdateProfilePage')}}">Update</a>

                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="css/Profile/profile.css">
@stop

@section('js')
    {{-- Custom JS for profile page could go here if needed --}}
@stop

