<div class="tab-pane text-left fade" id="vert-tabs-fees-types" role="tabpanel" aria-labelledby="vert-tabs-fees-types-tab">
    <!-- TABLE CARD -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                    <h3 class="card-title">Fee Types List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-success add-fee-type-modal" data-toggle="modal" data-target="#AddFeeTypeForm">
                            <i class="fas fa-plus"></i> Add Fee Type
                        </button>
                    </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap" id="fee_types">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fee Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeTypes ?? [] as $feeType)
                            <tr>
                                <td>{{ $feeType->id }}</td>
                                <td>{{ $feeType->name }}</td>
                                <td>
                                    @if($feeType->status == 'A')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="btn-groups">
                                    <button class="btn btn-warning edit-btn edit-fee-type-modal" data-id="{{ $feeType->id }}" data-name="{{ $feeType->name }}" data-status="{{ $feeType->status }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger delete-btn delete-fee-type-modal" data-id="{{ $feeType->id }}" data-title="{{ $feeType->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No fee types found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
            </div>

            <!-- Add Fee Type Modal -->
            <div class="modal fade" id="AddFeeTypeForm">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <form method="POST" action="{{ route('store_fee_type') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Add Fee Type</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="row modal-body">
                                <div class="card-body  card-success card-outline margin">
                                    <div class="row">
                                        <h6 class="text-uppercase font-weight-bold mb-1 col-md-12">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Fee Type Information
                                        </h6>
                                        <div class="form-group col-md-6 mb-3 ">
                                            <label for="name">Fee Type Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="A">Approve</option>
                                                <option value="D">Desapprove</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save Fee Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            {{-- Edit Fee Type Modal --}}
            <div class="modal fade" id="EditFeeTypeForm">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                    <form method="POST" action="{{ route('update_fee_type') }}">
                        @csrf
                        @method('post')
                        <input type="hidden" name="id" id="edit_fee_type_record_id">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h4>Edit Fee Type</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="row modal-body">
                                <div class="card-body  card-success card-outline margin">
                                    <div class="row">
                                        <h6 class="text-uppercase font-weight-bold mb-1 col-md-12">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Fee Information
                                        </h6>

                                        <div class="form-group col-md-6">
                                            <label for="edit_name">Fee Name</label>
                                            <input type="text" class="form-control" id="edit_name" name="name" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="edit_fee_type_status">Status</label>
                                            <select class="form-control" id="edit_fee_type_status" name="status" required>
                                                <option value="A">Active</option>
                                                <option value="I">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">Update Fee Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Delete Fee Type Modal --}}
            <div class="modal fade" id="DeleteFeeTypeForm">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Delete Fee Type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('delete_fee_type') }}">
                                @csrf
                                @method('post')
                                <div class="modal-body text-center mt-3">
                                    <h5 class="text-danger ">This action cannot be undone.</h5>
                                    <input type="hidden" name="id" id="delete_fee_type_id">
                                    <p>Are you sure you want to delete this fee type: <strong id="delete_fee_type_title"></strong></p>
                                </div>

                                <div class="modal-footer d-flex" style="gap: 10px;">
                                    <button type="button" class="btn btn-outline-secondary col-md-2 shadow" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-danger col-md-3 shadow">
                                        <span class="fas fa-trash"></span> Delete
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

