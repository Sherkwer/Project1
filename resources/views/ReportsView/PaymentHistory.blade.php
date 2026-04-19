@extends('adminlte::page')

@section('title', 'Payment Details')

@section('content_header')
    <h1>Payment Details</h1>
    <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Payment History</li>
    </ol>

    <!-- SEARCH -->
    <div class="row mb-3 justify-content-end">
        <div class="col-md-5">
            <div class="input-group">
                <input type="text" id="searchPayment" class="form-control" placeholder="Search...">
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')

<div class="container-fluid">

    <!-- SUMMARY CARDS -->
    <div class="row mb-3">

        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-muted">Total Collections</h5>
                    <h4 class="fw-bold">₱248,500</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-muted">GCash Collection</h5>
                    <h4 class="fw-bold text-success">₱89,200</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-muted">eWallet Collection</h5>
                    <h4 class="fw-bold text-primary">₱159,300</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-muted">Voucher</h5>
                    <h4 class="fw-bold text-warning">₱100</h4>
                </div>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Payment Records</h3>
        </div>

        <div class="card-body table-responsive p-0" style="height: 350px;">
            <table class="table table-head-fixed text-nowrap table-bordered">

                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Officer</th>
                        <th>Cash</th>
                        <th>eWallet</th>
                        <th>Voucher</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Fee Type</th>
                    </tr>
                </thead>

                <tbody id="paymentTable">

                    {{-- SAMPLE LOOP --}}
                    @for($i = 1; $i <= 10; $i++)
                    <tr>
                        <td>{{$i}}</td>
                        <td>Officer {{$i}}</td>
                        <td>₱1,000</td>
                        <td>₱500</td>
                        <td>₱200</td>
                        <td>23-000{{$i}}</td>
                        <td>Student {{$i}}</td>
                        <td>{{ date('Y-m-d') }}</td>
                        <td>Tuition</td>
                    </tr>
                    @endfor

                </tbody>

            </table>
        </div>
    </div>

</div>

@stop

@section('js')

<script>
/**
 * SIMPLE TABLE SEARCH (CLIENT SIDE)
 */
document.getElementById('searchPayment').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#paymentTable tr');

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>

@stop
