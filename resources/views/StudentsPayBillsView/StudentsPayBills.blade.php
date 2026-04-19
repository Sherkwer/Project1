@extends('adminlte::page')
@section('title', 'Students Pay Bills')
@section('content_header')
    <h1 class="mt-3">Students Pay Bills</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" href="#" style="cursor: pointer;">Dashboard</li>
        <li class="breadcrumb-item active" href="#" style="cursor: pointer;">Students Pay Bills</li>
    </ol>
@stop
@section('content')

    <div class="container-fluid">
        <!-- CARD -->
        <div class="card shadow-sm">

            <div class="card-header">
                <h5 class="mb-0">Pay Bills</h5>
                <small class="text-muted">Enter the details of payment process</small>
            </div>

            <div class="card-body">

                <!-- SUMMARY -->
                <div class="row text-center mb-4 g-3">
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="mb-1">Balance</h6>
                            <h5 class="fw-bold  text-red" style="font-size: 30px">₱ 100</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="mb-1">Paid</h6>
                            <h5 class="fw-bold  text-green" style="font-size: 30px">₱ 100</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3">
                            <h6 class="mb-1">Change</h6>
                            <h5 class="fw-bold text-yellow" style="font-size: 30px">₱ 100</h5>
                        </div>
                    </div>
                </div>

                <!-- FORM -->
                <div class="row g-3">

                    <!-- LEFT -->
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label class="form-label">Student ID Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="e.g. 23-111335" required>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">QR Code</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fees Type</label>
                            <div class="input-group">
                                <input type="text" class="form-control" required>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label class="form-label">OR Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-cog"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Received</label>
                            <input type="number" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-label">Payment Method</label>
                            <select id="e_status" name="e_status" class="form-control" required>
                                <option>Cash</option>
                                <option>GCash</option>
                                <option>Card</option>
                            </select>
                        </div>

                        <div class="text-end mt-4">
                            <button class="btn btn-success btn-lg col-6">
                                Pay
                            </button>
                        </div>

                    </div>

                </div>

                <!-- TABLE -->
                <div class="mt-4">
                    <h6 class="fw-bold">Violation Logs</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Student ID</th>
                                    <th>Violation</th>
                                    <th>Date</th>
                                    <th>Fee</th>
                                    <th>Paid off</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>23</td>
                                    <td>1</td>
                                    <td>2026-10-05</td>
                                    <td>00.00</td>
                                    <td><span class="badge bg-success" style="font-size: 20px">100</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>24-111333</td>
                                    <td>1</td>
                                    <td>2026-10-05</td>
                                    <td class="badge bg-danger" >100.00</td>
                                    <td><span style="font-size: 20px">00.00</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- FOOTER -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <button class="btn btn-secondary">Payment Report</button>
                        <small class="text-muted">Row Count: 1</small>
                    </div>

                </div>

            </div>
        </div>

    </div>
@stop

@section('css')

@stop

@section('js')
<!-- THis code is for showing record from the table  -->
<script>
        $(document).on('click', '.edit-modal-record', function() {
            $('.modal-title').text('Edit Record');
            $('#ea_id').val($(this).data('id'))
            $('#ea_title').val($(this).data('title'))
            $('#ea_content').val($(this).data('content'))

            $('#EditForm').modal('show');
        });
</script>
<script>
   $(document).on('click', '.delete-modal-record', function() {
            $('.modal-title').text('Remove Record');
            $('#delete_message').html('<p>Do you want to remove this record with the title <strong>' + ' - ' + $(this).data('title') + '</strong>?</p>');
           $('#da_id').val($(this).data('id'))
            $('#DeleteForm').modal('show');

        });
</script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
