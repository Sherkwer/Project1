
@php
    $u = auth()->user();

    // Resolve human-friendly names for display in the Overview panel.
    $areaDisplay = '—';
    if (!empty($areas)) {
        $areaObj = collect($areas)->firstWhere('area_code', $u->area_code);
        if (! $areaObj && isset($u->area_id)) {
            $areaObj = collect($areas)->firstWhere('id', $u->area_id);
        }
        if ($areaObj) {
            $areaDisplay = $areaObj->area_name ?? $areaObj->name ?? ($areaObj->area_code ?? ($u->area_code ?? '—'));
        } else {
            $areaDisplay = $u->area_code ?? '—';
        }
    } else {
        $areaDisplay = $u->area_code ?? '—';
    }

    // Department / college display
    $departmentDisplay = '—';
    $deptId = $u->department_id ?? $u->college_id ?? $u->college ?? null;
    if (!empty($college) && $deptId) {
        $deptObj = collect($college)->firstWhere('id', $deptId);
        if ($deptObj) {
            $departmentDisplay = $deptObj->name ?? ($deptObj->college_name ?? $departmentDisplay);
        }
    } else {
        if ($deptId) {
            $departmentDisplay = $deptId;
        }
    }

    // Organization display
    $organizationDisplay = '—';
    if (!empty($organizations) && ($u->organization_id ?? null)) {
        $orgObj = collect($organizations)->firstWhere('id', $u->organization_id);
        if ($orgObj) {
            $organizationDisplay = $orgObj->name ?? ($orgObj->description ?? $organizationDisplay);
        } else {
            $organizationDisplay = $u->organization_id ?? '—';
        }
    } else {
        $organizationDisplay = $u->organization_id ?? '—';
    }

    // Role display - prefer the model helper, then the supplied $roles collection.
    $roleDisplay = null;
    if (method_exists($u, 'getRoleName')) {
        $roleDisplay = $u->getRoleName();
    }
    if (! $roleDisplay) {
        if (! empty($roles)) {
            $roleObj = collect($roles)->firstWhere('id', $u->user_role ?? $u->role_id ?? null);
            if ($roleObj) {
                $roleDisplay = $roleObj->name;
            }
        }
    }
    $roleDisplay = $roleDisplay ?? ($u->user_role ?? '—');
@endphp

@push('css')
    <link rel="stylesheet" href="{{ asset('css/Profile/my-account.css') }}">

    <style>
        /* Custom input + dropdown button style */
        .custom-dropdown-wrapper {
            display: flex;
            gap: 0;
            position: relative;
        }

        .custom-dropdown-input {
            flex: 1;
            padding: 0.375rem 0.75rem;
            border: 1px solid #dee2e6;
            border-right: none;
            border-radius: 0.25rem 0 0 0.25rem;
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .custom-dropdown-input:focus {
            outline: none;
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .custom-dropdown-input::placeholder {
            color: #6c757d;
        }

        .custom-dropdown-btn {
            padding: 0.375rem 0.75rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: none;
            border-radius: 0 0.25rem 0.25rem 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            transition: background-color 0.15s ease-in-out;
        }

        .custom-dropdown-btn:hover {
            background-color: #e9ecef;
        }

        .custom-dropdown-btn:focus {
            outline: none;
            box-shadow: inset 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .custom-dropdown-btn i {
            color: #6c757d;
            transition: color 0.15s ease-in-out;
        }

        .custom-dropdown-btn.active i {
            color: #0d6efd;
            transform: rotate(180deg);
        }

        /* Dropdown menu */
        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin-top: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .custom-dropdown-menu.show {
            display: block;
        }

        .custom-dropdown-item {
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        .custom-dropdown-item:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        .custom-dropdown-item.active {
            background-color: #e7f1ff;
            color: #0d6efd;
            font-weight: 500;
        }

        .custom-dropdown-empty {
            padding: 0.75rem;
            color: #6c757d;
            text-align: center;
            font-size: 0.875rem;
        }

        /* Hidden select for form submission */
        .custom-dropdown-hidden {
            display: none;
        }

        /* Error state */
        .custom-dropdown-wrapper.is-invalid .custom-dropdown-input,
        .custom-dropdown-wrapper.is-invalid .custom-dropdown-btn {
            border-color: #dc3545;
        }

        .custom-dropdown-wrapper.is-invalid .custom-dropdown-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .custom-dropdown-invalid-feedback {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
    </style>
@endpush

<div id="ManageMyAccountPanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageMyAccountPanel') d-none @endunless">
    <div class="col-12 mb-3">


        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        @endif

        <div class="card shadow-sm my-account-card">
                    <div class="my-account-hero d-flex align-items-center">
                <span class="my-account-cover-shape shape-1"></span>
                <img src="{{ method_exists($u, 'adminlte_image') ? $u->adminlte_image() : asset('images/landing/user1-128x128.jpg') }}"
                     alt="Avatar" class="my-account-avatar mr-3">
                <div>
                    <h4 class="mb-1 font-weight-bold">{{ $u->fullname ?? trim(($u->fname ?? '').' '.($u->lname ?? '')) ?: 'User' }}</h4>
                    <div class="small opacity-90 mb-0">
                        <i class="fas fa-envelope mr-1"></i>{{ $u->email }}
                    </div>
                            @if(!empty($roleDisplay))
                                <span class="badge badge-light text-dark mt-2">{{ $roleDisplay }}</span>
                            @endif
                </div>
            </div>

            <div class="card-header p-0 border-bottom bg-white">
                <ul class="nav nav-tabs px-3 pt-2 mb-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#ma-overview" role="tab">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#ma-edit" role="tab">Edit profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#ma-password" role="tab">Password</a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link text-danger" data-toggle="tab" href="#ma-danger" role="tab">Deactivate Account</a>
                    </li>
                </ul>
            </div>

            <div class="card-body tab-content">

                {{-- OVERVIEW of Users information--}}
                    <div class="tab-pane fade show active" id="ma-overview" role="tabpanel">

                        <!-- PERSONAL INFORMATION SECTION -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small font-weight-bold mb-3">
                                <i class="fas fa-user mr-2"></i>Personal Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <dl class="mb-0 ">
                                        <dt>First name</dt>
                                        <dd>{{ $u->fname ?? '—' }}</dd>
                                        <dt>Middle name</dt>
                                        <dd>{{ $u->mname ?? '—' }}</dd>
                                    </dl>
                                </div>
                                <div class="col-md-4">
                                    <dl class="mb-0 ">
                                        <dt>Last name</dt>
                                        <dd>{{ $u->lname ?? '—' }}</dd>
                                        <dt>Full name</dt>
                                        <dd>{{ $u->fullname ?? '—' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- WORK INFORMATION SECTION -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small font-weight-bold mb-3">
                                <i class="fas fa-briefcase mr-2"></i>Work Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <dl class="mb-0 ">
                                        <dt>Area / campus</dt>
                                        <dd>{{ $areaDisplay }}</dd>
                                        <dt>Department</dt>
                                        <dd>{{ $departmentDisplay }}</dd>
                                    </dl>
                                </div>
                                <div class="col-md-4">
                                    <dl class="mb-0 ">
                                        <dt>Organization</dt>
                                        <dd>{{ $organizationDisplay }}</dd>
                                        <dt>Role</dt>
                                        <dd>{{ $roleDisplay }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- CONTACT & SECURITY SECTION -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small font-weight-bold mb-3">
                                <i class="fas fa-shield-alt mr-2"></i>Contact & Security
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <dl class="mb-0 ">
                                        <dt>Email</dt>
                                        <dd>{{ $u->email }}</dd>
                                    </dl>
                                </div>
                                <div class="col-md-4">
                                    <dl class="mb-0 ">
                                        <dt>Password</dt>
                                        <dd>
                                            <span class="password-mask">•••••••••••</span>
                                            <small class="text-muted d-block mt-1">Stored securely — it cannot be shown. Use <strong>Password</strong> tab to change it.</small>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            @php
                                $pwdChanged = $u->password_reset_at ?? $u->updated_at ?? null;
                            @endphp
                            @if($pwdChanged)
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <dl class="mb-0 ">
                                            <dt>Last profile update</dt>
                                            <dd>{{ $u->updated_at ? $u->updated_at->format('M j, Y g:i A') : '—' }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>


                {{-------   EDIT User Information     ---------------}}
                    <div class="tab-pane fade" id="ma-edit" role="tabpanel">
                        <form id="ma_profile_form" method="POST" action="{{ route('settings.my_account.profile') }}">
                            @csrf
                            <input type="hidden" name="settings_panel" value="ManageMyAccountPanel">

                            <!-- PERSONAL INFORMATION SECTION -->
                            <div class="mb-4">
                                <h6 class="text-muted text-uppercase small font-weight-bold mb-3">
                                    <i class="fas fa-user mr-2"></i>Personal Information
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ma_fname">First Name</label>
                                            <input type="text" class="form-control @error('fname') is-invalid @enderror" id="ma_fname" name="fname"
                                                value="{{ old('fname', $u->fname) }}">
                                            @error('fname')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ma_mname">Middle Name</label>
                                            <input type="text" class="form-control @error('mname') is-invalid @enderror" id="ma_mname" name="mname"
                                                value="{{ old('mname', $u->mname) }}">
                                            @error('mname')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ma_lname">Last Name</label>
                                            <input type="text" class="form-control @error('lname') is-invalid @enderror" id="ma_lname" name="lname"
                                                value="{{ old('lname', $u->lname) }}">
                                            @error('lname')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- WORK INFORMATION SECTION -->
                            <div class="mb-4">
                                <h6 class="text-muted text-uppercase small font-weight-bold mb-3">
                                    <i class="fas fa-briefcase mr-2"></i>Work Information
                                </h6>
                                @php
                                    // Find matching area by area_code if area_id is not set
                                    $selectedAreaId = old('area_id', $u->area_id ?? null);
                                    if (!$selectedAreaId && ($u->area_code ?? null)) {
                                        $selectedAreaId = collect($areas ?? [])->firstWhere('area_code', $u->area_code)?->id;
                                    }

                                    // Find matching college/department by known user fields
                                    $selectedCollegeId = old('college_id');
                                    if ($selectedCollegeId === null || $selectedCollegeId === '') {
                                        $selectedCollegeId = $u->college_id ?? $u->college ?? $u->department_id ?? null;
                                    }
                                    if (!$selectedCollegeId && ($u->college_name ?? null)) {
                                        $selectedCollegeId = collect($college ?? [])->firstWhere('name', $u->college_name)?->id;
                                    }
                                    if (!$selectedCollegeId && ($u->department_id ?? null)) {
                                        $selectedCollegeId = $u->department_id;
                                    }
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ma_area_input">Campus / Area</label>
                                            <div class="custom-dropdown-wrapper @error('area_id') is-invalid @enderror">
                                                <input type="text" class="custom-dropdown-input" id="ma_area_input">
                                                <button type="button" class="custom-dropdown-btn" id="ma_area_btn" data-target="ma_area_menu">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                                <select class="custom-dropdown-hidden" id="ma_area_id" name="area_id">
                                                    <option value=""></option>
                                                    @forelse($areas ?? [] as $area)
                                                        <option value="{{ $area->id }}" data-label="{{ $area->area_name }}"
                                                                @if($selectedAreaId == $area->id) selected @endif>
                                                            {{ $area->area_name }}
                                                        </option>
                                                    @empty
                                                        <option disabled>No campuses available</option>
                                                    @endforelse
                                                </select>
                                                <div class="custom-dropdown-menu" id="ma_area_menu"></div>
                                            </div>
                                            @error('area_id')<div class="custom-dropdown-invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ma_college_input">College / Department</label>
                                            <div class="custom-dropdown-wrapper @error('college_id') is-invalid @enderror">
                                                <input type="text" class="custom-dropdown-input" id="ma_college_input" >
                                                <button type="button" class="custom-dropdown-btn" id="ma_college_btn" data-target="ma_college_menu">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                                <select class="custom-dropdown-hidden" id="ma_college_id" name="college_id">
                                                    <option value=""></option>
                                                    @forelse($college ?? [] as $college_item)
                                                        <option value="{{ $college_item->id }}" data-label="{{ $college_item->name }}"
                                                                @if($selectedCollegeId == $college_item->id) selected @endif>
                                                            {{ $college_item->name }}
                                                        </option>
                                                    @empty
                                                        <option disabled>No colleges available</option>
                                                    @endforelse
                                                </select>
                                                <div class="custom-dropdown-menu" id="ma_college_menu"></div>
                                            </div>
                                            @error('college_id')<div class="custom-dropdown-invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ma_organization_input">Organization</label>
                                            <div class="custom-dropdown-wrapper @error('organization_id') is-invalid @enderror">
                                                <input type="text" class="custom-dropdown-input" id="ma_organization_input" placeholder="Select organization...">
                                                <button type="button" class="custom-dropdown-btn" id="ma_organization_btn" data-target="ma_organization_menu">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                                <select class="custom-dropdown-hidden" id="ma_organization_id" name="organization_id">
                                                    <option value=""></option>
                                                    @forelse($organizations ?? [] as $org)
                                                        <option value="{{ $org->id }}" data-label="{{ $org->name }}"
                                                                @if(old('organization_id', $u->organization_id ?? null) == $org->id) selected @endif>
                                                            {{ $org->name }}
                                                        </option>
                                                    @empty
                                                        <option disabled>No organizations available</option>
                                                    @endforelse
                                                </select>
                                                <div class="custom-dropdown-menu" id="ma_organization_menu"></div>
                                            </div>
                                            @error('organization_id')<div class="custom-dropdown-invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ma_role_input">Role</label>
                                            <div class="custom-dropdown-wrapper @error('role_id') is-invalid @enderror">
                                                <input type="text" class="custom-dropdown-input" id="ma_role_input" placeholder="Select role...">
                                                <button type="button" class="custom-dropdown-btn" id="ma_role_btn" data-target="ma_role_menu">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                                <select class="custom-dropdown-hidden" id="ma_role_id" name="role_id">
                                                    <option value=""></option>
                                                    @forelse($roles ?? [] as $role)
                                                        <option value="{{ $role->id }}" data-label="{{ $role->name }}"
                                                                @if(old('user_role', $u->user_role ?? null) == $role->id) selected @endif>
                                                            {{ $role->name }}
                                                        </option>
                                                    @empty
                                                        <option disabled>No roles available</option>
                                                    @endforelse
                                                </select>
                                                <div class="custom-dropdown-menu" id="ma_role_menu"></div>
                                            </div>
                                            @error('role_id')<div class="custom-dropdown-invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <!-- CONTACT & SECURITY SECTION -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small font-weight-bold mb-3">
                                <i class="fas fa-shield-alt mr-2"></i>Contact & Security
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ma_email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="ma_email" name="email"
                                               value="{{ old('email', $u->email) }}" required>
                                        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ACTION BUTTONS -->
                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                            <button type="reset" class="btn btn-secondary ml-2">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>

                {{-- PASSWORD --}}
                <div class="tab-pane fade" id="ma-password" role="tabpanel">
                    <div class="alert alert-info small mb-3">
                        <strong>Security:</strong>For your account’s safety, we recommend updating your password regularly and ensuring your security settings are up to date. Please create a strong, unique password and avoid sharing your login credentials with others.
                    </div>

                    <form id="ma_password_form" method="POST" action="{{ route('settings.my_account.password') }}">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageMyAccountPanel">

                        <div class="form-group">
                            <label for="ma_current_password">Current password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="ma_current_password"
                                   name="current_password" autocomplete="current-password" required>
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="ma_new_password">New password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="ma_new_password"
                                   name="password" autocomplete="new-password" required minlength="8">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="form-text text-muted">At least minimum of 8 characters.</small>
                        </div>
                        <div class="form-group">
                            <label for="ma_new_password_confirmation">Confirm new password</label>
                            <input type="password" class="form-control" id="ma_new_password_confirmation"
                                   name="password_confirmation" autocomplete="new-password" required minlength="8">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input @error('password_change_ack') is-invalid @enderror" id="ma_pw_ack"
                                   name="password_change_ack" value="1" {{ old('password_change_ack') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="ma_pw_ack">I confirm I want to change my password.</label>
                            @error('password_change_ack')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key mr-1"></i> Update password
                        </button>
                    </form>
                </div>

                {{-- DANGER / TERMINATE --}}
                <div class="tab-pane fade" id="ma-danger" role="tabpanel">
                    <div class="danger-zone p-3 mb-3">
                        <h6 class="text-danger font-weight-bold mb-2"><i class="fas fa-exclamation-triangle mr-1"></i> Deactivate account</h6>
                        <p class="text-muted small mb-2">
                            This is intentionally difficult: you must confirm your email, type an exact phrase, enter your password, and check the box.
                            Consider exporting any data you need before proceeding.
                        </p>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#TerminateAccountModal">
                            Start account termination…
                        </button>
                    </div>
                    <p class="small text-muted mb-0">
                        Administrators may be able to restore access depending on your organization’s policy.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Termination modal (outside tab panes so it always works) --}}
<div class="modal fade" id="TerminateAccountModal" tabindex="-1" role="dialog" aria-labelledby="TerminateAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('settings.my_account.terminate') }}">
            @csrf
            <input type="hidden" name="settings_panel" value="ManageMyAccountPanel">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="TerminateAccountModalLabel">Deactivate your account</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="font-weight-bold text-danger">This will sign you out and mark your account as deactivated.</p>
                    <ol class="small text-muted pl-3">
                        <li>Type <code>TERMINATE MY ACCOUNT</code> in the phrase field (exactly, uppercase).</li>
                        <li>Enter your account email: <strong>{{ $u->email }}</strong></li>
                        <li>Enter your current password.</li>
                        <li>Check the final acknowledgement.</li>
                    </ol>

                    <div class="form-group">
                        <label for="terminate_phrase">Confirmation phrase</label>
                        <input type="text" class="form-control @error('terminate_phrase') is-invalid @enderror" id="terminate_phrase"
                               name="terminate_phrase" placeholder="TERMINATE MY ACCOUNT" autocomplete="off">
                        @error('terminate_phrase')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="terminate_email">Confirm email</label>
                        <input type="email" class="form-control @error('terminate_email') is-invalid @enderror" id="terminate_email"
                               name="terminate_email" value="{{ old('terminate_email') }}" placeholder="{{ $u->email }}" required>
                        @error('terminate_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="terminate_password">Current password</label>
                        <input type="password" class="form-control @error('terminate_password') is-invalid @enderror" id="terminate_password"
                               name="terminate_password" autocomplete="current-password" required>
                        @error('terminate_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input @error('terminate_final_ack') is-invalid @enderror" id="terminate_final_ack"
                               name="terminate_final_ack" value="1" {{ old('terminate_final_ack') ? 'checked' : '' }} required>
                        <label class="form-check-label" for="terminate_final_ack">
                            I understand this action is serious and may require an administrator to restore access.
                        </label>
                        @error('terminate_final_ack')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-user-slash mr-1"></i> Deactivate account permanently
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
    <!-- Profile confirm modal -->
    <div class="modal fade" id="ConfirmProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-save mr-2"></i> Save profile changes</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">Are you sure you want to update your profile information?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm_profile_confirm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Password confirm modal -->
    <div class="modal fade" id="ConfirmPasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-key mr-2"></i> Change password</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">This will update your account password and require using the new password on next sign-in. Continue?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm_password_confirm" class="btn btn-danger">Change password</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            $(function () {
                var $profileForm = $('#ma_profile_form');
                var $passwordForm = $('#ma_password_form');

                // Initialize custom dropdown for each field
                initCustomDropdown('ma_area');
                initCustomDropdown('ma_college');
                initCustomDropdown('ma_organization');
                initCustomDropdown('ma_role');

                // Custom dropdown initialization function
                function initCustomDropdown(fieldName) {
                    var $input = $('#' + fieldName + '_input');
                    var $btn = $('#' + fieldName + '_btn');
                    var $menu = $('#' + fieldName + '_menu');
                    var $select = $('#' + fieldName + '_id');
                    var $wrapper = $btn.closest('.custom-dropdown-wrapper');

                    // Build menu from select options
                    function buildMenu(filterText) {
                        $menu.empty();
                        var hasOptions = false;
                        var selectedValue = $select.val();

                        $select.find('option').each(function () {
                            var $option = $(this);
                            var value = $option.val();
                            var label = $option.data('label') || $option.text();

                            if (!value) return; // Skip empty option

                            // Filter based on input
                            if (filterText && label.toUpperCase().indexOf(filterText.toUpperCase()) === -1) {
                                return;
                            }

                            hasOptions = true;
                            var $item = $('<div class="custom-dropdown-item" data-value="' + value + '">' + label + '</div>');

                            // Mark as active if selected
                            if (value == selectedValue) {
                                $item.addClass('active');
                            }

                            $item.on('click', function () {
                                selectOption(fieldName, value, label);
                            });

                            $menu.append($item);
                        });

                        if (!hasOptions) {
                            $menu.append('<div class="custom-dropdown-empty">No options found</div>');
                        }
                    }

                    // Select an option
                    function selectOption(field, value, label) {
                        $('#' + field + '_id').val(value);
                        $('#' + field + '_input').val(label);
                        $('#' + field + '_menu').removeClass('show');
                        $('#' + field + '_btn').removeClass('active');
                    }

                    // Input typing - filter options
                    $input.on('input', function () {
                        buildMenu($(this).val());
                        if (!$menu.hasClass('show')) {
                            $menu.addClass('show');
                            $btn.addClass('active');
                        }
                    });

                    // Button click - toggle dropdown
                    $btn.on('click', function (e) {
                        e.preventDefault();
                        if ($menu.hasClass('show')) {
                            $menu.removeClass('show');
                            $btn.removeClass('active');
                        } else {
                            buildMenu('');
                            $menu.addClass('show');
                            $btn.addClass('active');
                            $input.focus();
                        }
                    });

                    // Close menu when clicking outside
                    $(document).on('click', function (e) {
                        if (!$wrapper[0].contains(e.target)) {
                            $menu.removeClass('show');
                            $btn.removeClass('active');
                        }
                    });

                    // Display selected value on page load
                    if ($select.val()) {
                        var selectedLabel = $select.find('option:selected').data('label');
                        $input.val(selectedLabel);
                    }
                }

                if ($profileForm.length) {
                    $profileForm.on('submit', function (e) {
                        e.preventDefault();
                        $('#ConfirmProfileModal').modal('show');
                    });

                    $('#confirm_profile_confirm').on('click', function () {
                        $('#ConfirmProfileModal').modal('hide');
                        $profileForm.off('submit');
                        $profileForm.submit();
                    });
                }

                if ($passwordForm.length) {
                    $passwordForm.on('submit', function (e) {
                        e.preventDefault();
                        $('#ConfirmPasswordModal').modal('show');
                    });

                    $('#confirm_password_confirm').on('click', function () {
                        $('#ConfirmPasswordModal').modal('hide');
                        $passwordForm.off('submit');
                        $passwordForm.submit();
                    });
                }
            });
        })();
    </script>
@endpush

@if($errors->has('terminate_phrase') || $errors->has('terminate_email') || $errors->has('terminate_password') || $errors->has('terminate_final_ack'))
    @push('js')
        <script>
            $(function () {
                $('a[href="#ma-danger"]').tab('show');
                $('#TerminateAccountModal').modal('show');
            });
        </script>
    @endpush
@elseif($errors->has('current_password') || $errors->has('password') || $errors->has('password_change_ack'))
    @push('js')
        <script>
            $(function () {
                $('a[href="#ma-password"]').tab('show');
            });
        </script>
    @endpush
@elseif($errors->has('fname') || $errors->has('mname') || $errors->has('lname') || $errors->has('email'))
    @push('js')
        <script>
            $(function () {
                $('a[href="#ma-edit"]').tab('show');
            });
        </script>
    @endpush
@endif


