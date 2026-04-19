@extends('adminlte::page')

@section('title', 'Fees Management')

@section('content_header')
        <h1 class="mt-3">Fees Management</h1>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item">Fees Management</li>
        </ol>
        <div class="row mb-3 justify-content-end">
            <div class="col-md-6">
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text" id="searchTableInput" class="form-control" placeholder="Search Fees...">
                        <button type="button" class="btn btn-outline-secondary" id="searchTableBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="searchSuggestions" class="list-group position-absolute w-100 mt-1 d-none" style="z-index:1050;"></div>
                </div>
            </div>
        </div>
@stop

@section('content')
    <div class="row">
        {{-- FEES SUMMARY --}}
        <div class="container-fluid">
            {{-- Small boxes for displaying statistics --}}
            <!-- SUMMARY CARDS -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ count($fees) }}</h2>
                            <a class="text-muted">List of Fees</a>
                            <h4 class="fas fa-money-bill text-success float-right"></h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ $membershipFee ? '₱' . number_format($membershipFee->amount, 2) : 'N/A' }}</h2>
                            <a class="text-muted">Membership Fee</a>
                            <h4 class="fas fa-money-bill-wave text-warning float-right"></h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ $attendanceFee ? '₱' . number_format($attendanceFee->amount, 2) : 'N/A' }}</h2>
                            <a class="text-muted">Attendance Fee</a>
                            <h4 class="fas fa-calendar-check text-info float-right"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- FEES MANAGEMENT --}}
    <div class="container-fluid">
        <!-- ACTION BUTTONS -->
        <div class="d-flex justify-content-end mb-3 gap-2" hidden>
            <button class="btn btn-success" hidden>
                <i class="fas fa-plus"></i> Add Collection
            </button>

            <button class="btn btn-primary" hidden>
                <i class="fas fa-plus"></i> Add Expense
            </button>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                <i class="fas fa-money-bill"></i>
                Manage Fees & Fee Types
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-5 col-sm-2">
                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link Active" id="vert-tabs-fees-tab" data-toggle="pill" href="#vert-tabs-fees" role="tab" aria-controls="vert-tabs-fees" aria-selected="false">Fees</a>

                        <a class="nav-link" id="vert-tabs-fees-types-tab" data-toggle="pill" href="#vert-tabs-fees-types" role="tab" aria-controls="vert-tabs-fees-types" aria-selected="false">Fees Types</a>


                        </div>
                    </div>

                    <div class="col-7 col-sm-10">
                        <div class="tab-content" id="vert-tabs-tabContent">

                            @include('FeesView.ListOfFees')

                            @include('FeesView.FeeTypes')


                        </div>
                    </div>
                </div>
            </div>
        </div>
          <!-- /.card -->
</div>

@stop

@section('css')

<link rel="stylesheet" href="{{asset('css/card_statistics.css') }}">
<link rel="stylesheet" href="{{ asset('css/buttons-text-hover-effect.css') }}">
@stop

@section('js')

    <script>

         $(document).on('click', '.edit-modal-record', function(e) {
            e.preventDefault();
            var Id = $(this).data('id');
            var FeeName = $(this).data('fee_name');
            var Amount = $(this).data('amount');
            var Description = $(this).data('description');
            var Status = $(this).data('status');
            var AreaCode = $(this).data('area_code');
            var CollegeId = $(this).data('college_id');
            var CollegeName = $(this).data('college_name');
            var OrganizationId = $(this).data('organization_id');
            var OrganizationName = $(this).data('organization_name');
            var FeeTypeId = $(this).data('fee_type_id');
            var FeeTypeName = $(this).data('fee_type_name');

            $('#edit_fee_id').val(Id);
            $('#edit_fee_name').val(FeeName);
            $('#edit_amount').val(Amount);
            $('#edit_description').val(Description);
            $('#edit_fee_status').val(Status);
            $('#edit_area_code').val(AreaCode);
            $('#edit_college_id').val(CollegeId);
            $('#edit_college_id_display').val(CollegeName || CollegeId);
            $('#edit_organization_id').val(OrganizationId);
            $('#edit_organization_id_display').val(OrganizationName || OrganizationId);
            $('#edit_fee_fee_type_id').val(FeeTypeId);
            $('#edit_fee_status').val(Status);

            $('#EditFeeForm').modal('show');
        });

        $(document).on('click', '.view-modal-record', function(e) {
            e.preventDefault();
            var FeeName = $(this).data('fee_name');
            var Amount = $(this).data('amount');
            var Description = $(this).data('description');
            var Status = $(this).data('status');
            var AreaCode = $(this).data('area_code');
            var CollegeName = $(this).data('college_name');
            var OrganizationName = $(this).data('organization_name');
            var FeeTypeName = $(this).data('fee_type_name');

            $('#view_fee_name').val(FeeName);
            $('#view_amount').val('₱'+parseFloat(Amount).toFixed(2));
            $('#view_description').val(Description);
            $('#view_status').val(Status == 'A' ? 'Approve' : 'Disapprove');
            $('#view_area_code').val(AreaCode);
            $('#view_college_name').val(CollegeName);
            $('#view_organization_name').val(OrganizationName || '-');
            $('#view_fee_type_name').val(FeeTypeName || '-');

            $('#ViewFeeForm').modal('show');
        });
</script>
<script>
   $(document).on('click', '.delete-modal-record', function() {
            $('.modal-title').text('Remove Record');
            $('#delete_fee_title').html('<p><strong>' + $(this).data('title') + '</strong>?</p>');
           $('#delete_fee_id').val($(this).data('id'))
            $('#DeleteFeeForm').modal('show');

        });
</script>

<script>
    $(document).on('click', '.edit-fee-type-modal', function(e) {
        e.preventDefault();
        var Id = $(this).data('id');
        var Name = $(this).data('name');
        var Status = $(this).data('status');

        $('#edit_fee_type_record_id').val(Id);
        $('#edit_name').val(Name);
        $('#edit_fee_type_status').val(Status);

        $('#EditFeeTypeForm').modal('show');
    });
</script>
<script>
    $(document).on('click', '.delete-fee-type-modal', function() {
        $('.modal-title').text('Remove Record');
        $('#delete_fee_type_title').html('<p><strong>' + $(this).data('title') + '</strong>?</p>');
        $('#delete_fee_type_id').val($(this).data('id'));
        $('#DeleteFeeTypeForm').modal('show');
    });
</script>

@stop
<script>
    $(document).on('click', '.add-fee-type-modal', function(e) {
        e.preventDefault();
        $('#AddFeeTypeForm').modal('show');
    });
</script>
