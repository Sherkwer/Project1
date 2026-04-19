  {{-- List of Fees --}}
    <div class="tab-pane text-left fade active show" id="vert-tabs-fees" role="tabpanel" aria-labelledby="vert-tabs-fees-tab">
        <!-- TABLE CARD -->
        <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header ">
                        <h3 class="card-title">List of Fees</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-success add-modal-record" data-toggle="modal" data-target="#AddFeeForm">
                                <i class="fas fa-plus"></i> Add Fee
                            </button>
                        </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed text-nowrap" id="fees">
                            <thead>
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Fee Name</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Fee Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fees as $fee)
                                <tr>
                                    <td hidden>{{ $fee->id }}</td>
                                    <td>{{ $fee->fee_name }}</td>
                                    <td>₱{{ number_format($fee->amount, 2) }}</td>
                                    <td>{{ $fee->description }}</td>
                                    <td>{{ optional($feeTypes->where('id', $fee->fee_type_id)->first())->name }}</td>
                                    <td>
                                        @if($fee->status == 'A')
                                            <span class="badge badge-success">Aproved</span>
                                        @else
                                            <span class="badge badge-secondary">Dissaproved</span>
                                        @endif
                                    </td>

                                    <td class="btn-groups">
                                        <button class="btn btn-info view-btn  view-modal-record" data-id="{{ $fee->id }}" data-fee_name="{{ $fee->fee_name }}" data-amount="{{ $fee->amount }}" data-description="{{ $fee->description }}" data-status="{{ $fee->status }}" data-area_code="{{ $fee->area_code }}" data-college_id="{{ $fee->college_id }}" data-college_name="{{ optional($colleges->where('id',$fee->college_id)->first())->name }}" data-organization_id="{{ $fee->organization_id }}" data-organization_name="{{ optional($organizations->where('id', $fee->organization_id)->first())->name }}" data-fee_type_id="{{ $fee->fee_type_id }}" data-fee_type_name="{{ optional($feeTypes->where('id',$fee->fee_type_id)->first())->name }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning edit-btn  edit-modal-record" data-id="{{ $fee->id }}" data-fee_name="{{ $fee->fee_name }}" data-amount="{{ $fee->amount }}" data-description="{{ $fee->description }}" data-status="{{ $fee->status }}" data-area_code="{{ $fee->area_code }}" data-college_id="{{ $fee->college_id }}" data-college_name="{{ optional($colleges->where('id',$fee->college_id)->first())->name }}" data-organization_id="{{ $fee->organization_id }}" data-organization_name="{{ optional($organizations->where('id', $fee->organization_id)->first())->name }}" data-fee_type_id="{{ $fee->fee_type_id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger delete-btn  delete-modal-record" data-id="{{ $fee->id }}" data-title="{{ $fee->fee_name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No fees found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                <!-- /.card -->
                </div>

                <!-- Add Fee Modal -->
                <div class="modal fade" id="AddFeeForm">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                        <form method="POST" action="{{ route('store_fee') }}">
                            @csrf
                            <div class=" modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Fee</h4>
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
                                                <label for="fee_name">Fee Name</label>
                                                <input type="text" class="form-control" id="fee_name" name="fee_name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="amount">Amount</label>
                                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="fee_type_id">Fee Type</label>
                                                <select class="form-control" id="fee_type_id" name="fee_type_id">
                                                    <option value="">Select Fee Type</option>
                                                    @foreach($feeTypes ?? [] as $feeType)
                                                        <option value="{{ $feeType->id }}">{{ $feeType->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="A">Approve</option>
                                                    <option value="D">Disapprove</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description"></textarea>
                                            </div>

                                            <div class="form-group col-md-6" hidden>
                                                <label for="area_code">Campus</label>
                                                <input type="text" class="form-control" id="area_code" name="area_code" value="{{ $user->area_code }}" readonly required>
                                            </div>
                                            <div class="form-group col-md-6" hidden>
                                                <label for="college_id_display">College</label>
                                                <input type="text" class="form-control" id="college_id_display" value="{{ optional($colleges->where('id', $user->college_id ?? $user->department_id)->first())->name ?? '' }}" readonly>
                                                <input type="hidden" id="college_id" name="college_id" value="{{ old('college_id', $user->college_id ?? $user->department_id ?? '') }}">
                                            </div>
                                            <div class="form-group col-md-9" hidden>
                                                <label for="organization_id_display">Organization</label>
                                                <input type="text" class="form-control" id="organization_id_display" value="{{ $user->organization_id ? optional($organizations->where('id', $user->organization_id)->first())->name ?? 'Organization #'.$user->organization_id : '' }}" readonly>
                                                <input type="hidden" id="organization_id" name="organization_id" value="{{ old('organization_id', $user->organization_id ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer ">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Save Fee</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Fee Modal -->
                <div class="modal fade" id="EditFeeForm">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                        <form method="POST" action="{{ route('update_fee') }}">
                            @csrf
                            @method('post')
                            <input type="hidden" name="id" id="edit_fee_id">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Fee</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class=" modal-body">
                                    <div class="card-body  card-warning card-outline margin">
                                        <div class="row">
                                            <h6 class="text-uppercase font-weight-bold mb-1 col-md-12">
                                                <i class="fas fa-money-bill-wave mr-2"></i>Fee Information
                                            </h6>
                                            <div class="form-group col-md-6">
                                                <label for="edit_fee_name">Fee Name</label>
                                                <input type="text" class="form-control" id="edit_fee_name" name="fee_name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="edit_amount">Amount</label>
                                                <input type="number" step="0.01" class="form-control" id="edit_amount" name="amount" required>
                                            </div>
                                            <div class="form-group col-md-6" hidden>
                                                <label for="edit_area_code">Campus</label>
                                                <input type="text" class="form-control" id="edit_area_code" name="area_code"  required>
                                            </div>
                                            <div class="form-group col-md-6" hidden>
                                                <label for="edit_college_id_display">College</label>
                                                <input type="text" class="form-control" id="edit_college_id_display" >
                                                <input type="hidden" id="edit_college_id" name="college_id">
                                            </div>
                                            <div class="form-group col-md-9" hidden>
                                                <label for="edit_organization_id_display">Organization</label>
                                                <input type="text" class="form-control" id="edit_organization_id_display" >
                                                <input type="hidden" id="edit_organization_id" name="organization_id">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="edit_fee_fee_type_id">Fee Type</label>
                                                <select class="form-control" id="edit_fee_fee_type_id" name="fee_type_id">
                                                    <option value="">Select Fee Type</option>
                                                    @foreach($feeTypes ?? [] as $feeType)
                                                        <option value="{{ $feeType->id }}">{{ $feeType->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="edit_fee_status">Status</label>
                                                <select class="form-control" id="edit_fee_status" name="status" required>
                                                    <option value="A">Approve</option>
                                                    <option value="D">Disapprove</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="edit_description">Description</label>
                                                <textarea class="form-control" id="edit_description" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Update Fee</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- View Fee Modal --}}
                <div class="modal fade" id="ViewFeeForm">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                        <div class="modal-content">
                            <div class="modal-header text-dark">
                                <h4 class="modal-title">View Fee</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body  card-info card-outline margin">
                                <div class="row">
                                    <h6 class=" text-uppercase font-weight-bold mb-1 col-md-12">
                                        <i class="fas fa-money-bill-wave mr-2"></i>Fee Information
                                    </h6>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fee Name</label>
                                            <input type="text" class="form-control" id="view_fee_name" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="text" class="form-control" id="view_amount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fee Type</label>
                                            <input type="text" class="form-control" id="view_fee_type_name" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input type="text" class="form-control" id="view_status" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" id="view_description" rows="2" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="card-body  card-info card-outline margin">
                                <div class="row">
                                    <h6 class="text-uppercase font-weight-bold mb-1 col-md-12">
                                        <i class="fas fa-building mr-2"></i>Fee allocated to
                                    </h6>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Campus</label>
                                            <input type="text" class="form-control" id="view_area_code" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>College</label>
                                            <input type="text" class="form-control" id="view_college_name" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Organization</label>
                                            <input type="text" class="form-control" id="view_organization_name" readonly>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Delete Fee Modal --}}
                <div class="modal fade" id="DeleteFeeForm">
                    <div class="modal-dialog modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Fee</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('delete_fee') }}">
                                    @csrf
                                    @method('post')
                                    <div class="modal-body text-center mt-3">
                                        <h5 class="text-danger ">This action cannot be undone.</h5>
                                        <input type="hidden" name="id" id="delete_fee_id">
                                        <p>Are you sure you want to delete this fee: <strong id="delete_fee_title"></strong></p>
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
