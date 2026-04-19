<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #e6e6e6;
    font-family: Arial, sans-serif;
}

.container-card {
    max-width: 1100px;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    margin-top: 50px;
}

.left-panel {
    background: #2F4B8F;
    color: #fff;
    text-align: center;
    padding: 40px 20px;
}

.logo-circle {
    width: 100px;
    height: 100px;
    background: #fff;
    border-radius: 50%;
    margin: 0 auto 20px;
}

.right-panel {
    padding: 40px;
    position: relative;
}

.password-rules {
    font-size: 13px;
}

.valid { color: green; }
.invalid { color: red; }

/* Validation Popup Dialog */
.validation-popup {
    display: none;
    position: absolute;
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 6px;
    padding: 12px 15px;
    font-size: 13px;
    color: #856404;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    z-index: 1000;
    max-width: 280px;
    word-wrap: break-word;
    animation: slideDown 0.3s ease;
}

.validation-popup.error {
    background: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.validation-popup.success {
    background: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    display: block;
}

.validation-popup.warning {
    display: block;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-group {
    position: relative;
    margin-bottom: 20px;
}

</style>
</head>
<body>

<div class="container d-flex justify-content-center">
<div class="row container-card g-0 w-100">

<!-- LEFT PANEL -->
<div class="col-lg-4 left-panel d-flex flex-column align-items-center justify-content-center">
    <div class="logo-circle"></div>
    <h2>College of Computing Scinec</h2>
    <p>CCS</p>
</div>

<!-- RIGHT PANEL -->
<div class="col-lg-8 right-panel">

<h3 class="text-center mb-4">Student Registration Form</h3>

<form method="POST" action="{{ route('register_student') }}">
@csrf

<div class="row g-3">

<div class="col-md-6">
    <label>Student ID *</label>
    <input id="student_id" name="student_id" type="text"
           class="form-control" placeholder="23-111111" required>
    <div id="studentIdPopup" class="validation-popup">
        Format must be 2 digits, dash, 6 digits (Example: 23-123456)
    </div>
</div>

<div class="col-md-6">
<label>Email *</label>
<input name="email" type="email" class="form-control" required>
</div>

<div class="col-md-4">
<label>Last Name *</label>
<input name="lname" type="text" class="form-control" required>
</div>

<div class="col-md-4">
<label>First Name *</label>
<input name="fname" type="text" class="form-control" required>
</div>

<div class="col-md-4">
<label>Middle Name</label>
<input name="mname" type="text" class="form-control">
</div>

<div class="col-md-4" hidden>
<label>Full Name</label>
<input name="fullname" type="text" class="form-control" >
</div>

<div class="col-md-3">
<label>Age</label>
<input name="age" type="number" class="form-control">
</div>

<div class="col-md-3">
<label>Sex</label>
<select name="sex" class="form-select">
<option value="M">Male</option>
<option value="F">Female</option>
</select>
</div>

<div class="col-12">
<label>Address</label>
<input name="address" type="text" class="form-control">
</div>

<div class="col-md-4">
<label>Area Code</label>
<input name="area_code" type="text" class="form-control">
</div>

<div class="col-md-4">
<label>College Code</label>
<input name="college_code" type="text" class="form-control">
</div>

<div class="col-md-4">
<label>Course Code</label>
<input name="course_code" type="text" class="form-control">
</div>

<div class="col-md-4">
<label>Year Level</label>
<input name="year_level" type="text" class="form-control">
</div>

<div class="col-md-4">
<label>Term</label>
<input name="term" type="text" class="form-control">
</div>

<div class="col-md-4">
<label>School Year</label>
<input name="sy" type="text" class="form-control">
</div>

<div class="col-md-6">
<label>Status</label>
<select name="status" class="form-select">
<option value="A">Active</option>
<option value="I">Inactive</option>
</select>
</div>

<!-- PASSWORD -->
<div class="col-md-6">
<label>Password *</label>
<input id="password" name="password" type="password" class="form-control" required>

<!-- Strength Bar -->
    <div class="progress mt-2" style="height:8px;">
        <div id="strengthBar" class="progress-bar" style="width:0%"></div>
    </div>
    <small id="strengthText"></small>

<div id="passwordPopup" class="validation-popup warning" >
    <strong>Password Requirements:</strong>
    <div id="length" class="invalid" style="margin-top: 8px;">• At least 8 characters</div>
    <div id="letter" class="invalid">• Contains A & a letter</div>
    <div id="number" class="invalid">• Contains number</div>
    <div id="symbol" class="invalid">• Contains symbol</div>
</div>
</div>

<!-- CONFIRM PASSWORD -->
<div class="col-md-6">
<label>Confirm Password *</label>
<input id="confirm_password" name="password_confirmation" type="password" class="form-control" required>
<div id="matchPopup" class="validation-popup" style="display: none;">
    Passwords must match
</div>
</div>

</div>

<div class="d-flex gap-3 mt-4">
<button type="reset" class="btn btn-secondary flex-fill">Cancel</button>
<button type="submit" id="submitBtn" class="btn btn-primary flex-fill" disabled>Register</button>
</div>

</form>

</div>
</div>
</div>

<script>
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm_password");
const strengthBar = document.getElementById("strengthBar");
const strengthText = document.getElementById("strengthText");
const submitBtn = document.getElementById("submitBtn");
const studentId = document.getElementById("student_id");
const studentIdPopup = document.getElementById("studentIdPopup");
const passwordPopup = document.getElementById("passwordPopup");
const matchPopup = document.getElementById("matchPopup");

// AUTO FULLNAME
const fname = document.querySelector("input[name='fname']");
const lname = document.querySelector("input[name='lname']");
const mname = document.querySelector("input[name='mname']");
const fullname = document.getElementById("fullname");

function generateFullName() {
    fullname.value = `${fname.value} ${mname.value} ${lname.value}`.replace(/\s+/g, ' ').trim();
}

fname.addEventListener("keyup", generateFullName);
lname.addEventListener("keyup", generateFullName);
mname.addEventListener("keyup", generateFullName);

// PASSWORD STRENGTH
function checkStrength() {
    let value = password.value;
    let strength = 0;

    // Update password requirement indicators
    if (value.length >= 8) {
        document.getElementById("length").classList.remove("invalid");
        document.getElementById("length").classList.add("valid");
        strength++;
    } else {
        document.getElementById("length").classList.add("invalid");
        document.getElementById("length").classList.remove("valid");
    }

    if (/[A-Z]/.test(value)) {
        document.getElementById("letter").classList.remove("invalid");
        document.getElementById("letter").classList.add("valid");
        strength++;
    } else {
        document.getElementById("letter").classList.add("invalid");
        document.getElementById("letter").classList.remove("valid");
    }

    if (/[0-9]/.test(value)) {
        document.getElementById("number").classList.remove("invalid");
        document.getElementById("number").classList.add("valid");
        strength++;
    } else {
        document.getElementById("number").classList.add("invalid");
        document.getElementById("number").classList.remove("valid");
    }

    if (/[^A-Za-z0-9]/.test(value)) {
        document.getElementById("symbol").classList.remove("invalid");
        document.getElementById("symbol").classList.add("valid");
        strength++;
    } else {
        document.getElementById("symbol").classList.add("invalid");
        document.getElementById("symbol").classList.remove("valid");
    }

    let percent = (strength / 4) * 100;
    strengthBar.style.width = percent + "%";

    // Show/hide password popup based on validation
    if (strength === 4) {
        // All requirements met - hide popup
        passwordPopup.style.display = "none";
    } else if (value.length > 0) {
        // Still validating - show popup
        passwordPopup.style.display = "block";
    } else {
        // No input - hide popup
        passwordPopup.style.display = "none";
    }

    if (strength <= 1) {
        strengthBar.className = "progress-bar bg-danger";
        strengthText.innerText = "Weak";
        passwordPopup.classList.add("error");
        passwordPopup.classList.remove("warning", "success");
    } else if (strength == 2 || strength == 3) {
        strengthBar.className = "progress-bar bg-warning";
        strengthText.innerText = "Medium";
        passwordPopup.classList.add("warning");
        passwordPopup.classList.remove("error", "success");
    } else {
        strengthBar.className = "progress-bar bg-success";
        strengthText.innerText = "Strong";
        passwordPopup.classList.add("success");
        passwordPopup.classList.remove("error", "warning");
    }

    return strength === 4;
}

// PASSWORD MATCH
function validateMatch() {
    if (confirmPassword.value.length > 0) {
        if (password.value === confirmPassword.value) {
            // Passwords match - hide popup
            matchPopup.style.display = "none";
            return true;
        } else {
            // Passwords don't match - show error popup
            matchPopup.classList.add("error");
            matchPopup.classList.remove("success");
            matchPopup.style.display = "block";
            return false;
        }
    } else {
        // No input - hide popup
        matchPopup.style.display = "none";
        return false;
    }
}

// STUDENT ID FORMAT VALIDATION
function validateStudentId() {
    const pattern = /^[0-9]{2}-[0-9]{6}$/;
    const valid = pattern.test(studentId.value);

    if (studentId.value.length > 0) {
        if (valid) {
            // Valid format - hide popup
            studentIdPopup.style.display = "none";
        } else {
            // Invalid format - show error popup
            studentIdPopup.classList.add("error");
            studentIdPopup.classList.remove("success");
            studentIdPopup.style.display = "block";
        }
    } else {
        // No input - hide popup
        studentIdPopup.style.display = "none";
    }

    return valid;
}

function validateForm() {
    let studentIdValid = studentId.value.length > 0 && validateStudentId();
    let passwordValid = checkStrength();
    let matchValid = validateMatch();

    if (studentIdValid && passwordValid && matchValid) {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}

password.addEventListener("keyup", () => {
    checkStrength();
    validateForm();
});

confirmPassword.addEventListener("keyup", () => {
    validateMatch();
    validateForm();
});

studentId.addEventListener("keyup", () => {
    validateStudentId();
    validateForm();
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
