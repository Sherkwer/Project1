<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register Account</title>

<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/registration.css') }}">
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="row container-card g-0 w-100">

        <!-- LEFT PANEL -->
        <div class="col-lg-4 left-panel d-flex flex-column align-items-center justify-content-center">
            <div class="logo-circle"></div>
            <h2>College Admin</h2>
            <p>Management System</p>
        </div>

        <!-- RIGHT PANEL -->
        <div class="col-lg-8 right-panel">
            <div class="top-link" onclick="window.location.href='{{ route('usersLogin') }}'" style="cursor: pointer;">← <span>Login</span></div>

            <div class="form-title">
                <h1>Register Account</h1>
                <p>Enter your details to create your Account</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input name="fname" type="text" class="form-control" placeholder="John" required value="{{ old('fname') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Middle Name</label>
                        <input name="mname" type="text" class="form-control" placeholder="D." value="{{ old('mname') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input name="lname" type="text" class="form-control" placeholder="Doe" required value="{{ old('lname') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                 {{--    <div class="col-md-6">
                        <label class="form-label">Age</label>
                        <input name="age" type="number" class="form-control" placeholder="20" value="{{ old('age') }}">
                    </div> --}}

                    {{-- <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input name="address" type="text" class="form-control" placeholder="Lamut Ifugao" value="{{ old('address') }}">
                    </div> --}}

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="Staff" {{ old('role') == 'Staff' ? 'selected' : '' }}>Staff</option>
                            <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" placeholder="john.doe@college.edu" required value="{{ old('email') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input name="password" type="password" class="form-control" placeholder="********" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input name="password_confirmation" type="password" class="form-control" placeholder="********" required>
                    </div>

                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="reset" class="btn cancel-btn flex-fill">Cancel</button>
                    <button type="submit" class="btn register-btn flex-fill">Register</button>
                </div>

                <div class="bottom-text">
                    Already have an account? <a href="{{ route('usersLogin') }}">Login</a>
                </div>

            </form>
        </div>

    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
