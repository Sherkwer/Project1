@extends('adminlte::page')

@section('title', 'User Report')

@section('content_header')
    <h1 class="mt-3">User Report</h1>
    <div class="d-flex justify-content-between align-items-center ">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item">User Report</li>
        </ol>

        <!-- Search -->
        <div class="col-md-6 card-tools d-flex mb-3" style="margin-right: 10px;">
            <input type="text" class="form-control" placeholder="Search">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
@stop

@section('content')

<div class="container-fluid">

    <!-- TOP BAR -->

    <!-- FORM SECTION -->
    <div class="card mb-3">
        <div class="card-body">

            <div class="row g-3 align-items-end">

                <!-- Payee -->
                <div class="col-md-3">
                    <label class="form-label">Payee</label>
                    <select class="form-control" id="payee">
                        <option>Select Name</option>
                        <option>John Doe</option>
                        <option>Jane Smith</option>
                        <option>Michael Brown</option>
                    </select>
                </div>

                <!-- Collection -->
                <div class="col-md-3">
                    <label class="form-label">Collection Amount</label>
                    <input type="text" class="form-control" id="collection" value="5000.00" readonly>
                </div>

                <!-- Submit -->
                <div class="col-md-3">
                    <label class="form-label">Submit Amount</label>
                    <input type="number" class="form-control" id="submit_amount" placeholder="Enter amount">
                </div>

                <!-- Button -->
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary" id="submitBtn">Submit</button>
                </div>

            </div>

        </div>
    </div>

    <!-- TABLE -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title">Collection Records</h5>
        </div>

        <div class="card-body table-responsive p-0" style="max-height: 300px;">
            <table class="table table-hover text-nowrap">
                <thead class="table-light">
                    <tr>
                        <th>Payee Name</th>
                        <th>Collection</th>
                        <th>Date Collected</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody id="recordTable">
                    <tr>
                        <td>John Doe</td>
                        <td>2,500.00</td>
                        <td>2024-01-15</td>
                        <td>09:30 AM</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>3,200.00</td>
                        <td>2024-01-15</td>
                        <td>10:15 AM</td>
                    </tr>
                    <tr>
                        <td>Michael Brown</td>
                        <td>1,800.00</td>
                        <td>2024-01-14</td>
                        <td>02:45 PM</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SUMMARY -->
    <div class="card mb-3">
        <div class="card-header">
            <h5>Summary Information</h5>
        </div>

        <div class="card-body">

            <div class="row mb-2">
                <div class="col-md-6">Total Collection of Users</div>
                <div class="col-md-6 text-end fw-bold" id="totalUsers">20,400.00</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">Total Collectible Amount</div>
                <div class="col-md-6 text-end fw-bold">35,000.00</div>
            </div>

            <div class="row">
                <div class="col-md-6">Total Collection Submitted</div>
                <div class="col-md-6 text-end fw-bold" id="totalSubmitted">18,750.00</div>
            </div>

        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="d-flex flex-wrap gap-2 justify-content-between">

        <button class="btn btn-primary flex-fill">Financial Statement on Fines</button>
        <button class="btn btn-outline-secondary flex-fill">View Payment Logs</button>
        <button class="btn btn-outline-secondary flex-fill">Submitted Reports</button>
        <button class="btn btn-primary flex-fill">Log On</button>

    </div>

</div>

@stop

@section('js')

<script>
document.getElementById('submitBtn').addEventListener('click', function() {

    let submitAmount = parseFloat(document.getElementById('submit_amount').value || 0);
    let totalSubmitted = document.getElementById('totalSubmitted');

    let currentTotal = parseFloat(totalSubmitted.innerText.replace(/,/g,'')) || 0;

    let newTotal = currentTotal + submitAmount;

    totalSubmitted.innerText = newTotal.toLocaleString(undefined, {minimumFractionDigits: 2});

    alert("Amount Submitted Successfully!");
});
</script>

@stop
