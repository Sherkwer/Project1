{{-- Manage Campus Panel --}}
<style>

</style>
    <div id="ManageCampusPanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageCampusPanel') d-none @endunless">
        <div class="col-12 mb-3">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header">
                    <h3 class="card-title">Manage Campus</h3>

                    <div class="card-tools">
                        <button type="button"
                                class="btn btn-success btn-md add-modal-record"
                                data-toggle="modal"
                                data-target="#AddCampusModal">
                            <i class="fas fa-plus"></i> Add New Campus
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="card-body table-responsive p-0" style="height: 450px">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th>Area Code</th>
                                <th>Area Name</th>
                                <th>Address</th>
                                <th class="text-center">Tools</th>
                            </tr>
                        </thead>

                        <tbody id="campusTableBody">
                            @forelse($campus as $c)
                            <tr>

                                <td hidden>{{ $c->id }}</td>

                                <td>{{ $c->area_code }}</td>
                                <td>{{ $c->area_name }}</td>
                                <td>{{ $c->area_address }}</td>
                                <td hidden>
                                    @if($c->area_report_header_path)
                                        <span class="badge bg-info">Available</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>

                                <!-- TOOLS -->
                                <td class="btn-groups justify-content-center">
                                        <!-- VIEW -->
                                        <a class="btn btn-info view-btn view-campus"
                                                data-id="{{ $c->id }}"
                                                data-area_code="{{ $c->area_code }}"
                                                data-area_address="{{ $c->area_address }}"
                                                data-report="{{ $c->area_report_header_path }}"
                                                data-template="{{ $c->receipt_template }}"
                                                data-print="{{ $c->receipt_print_option }}"
                                                data-toggle="modal"
                                                data-target="#ViewCampusModal">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a class="btn btn-warning edit-btn edit-campus"
                                                data-id="{{ $c->id }}"
                                                data-area_code="{{ $c->area_code }}"
                                                data-area_address="{{ $c->area_address }}"
                                                data-report="{{ $c->area_report_header_path }}"
                                                data-template="{{ $c->receipt_template }}"
                                                data-print="{{ $c->receipt_print_option }}"
                                                data-toggle="modal"
                                                data-target="#EditCampusModal">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <a hidden class="btn btn-danger delete-btn delete-campus"
                                                data-id="{{ $c->id }}"
                                                data-area_code="{{ $c->area_code }}"
                                                data-toggle="modal"
                                                data-target="#DeleteCampusModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No campus records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

                <!-- FOOTER -->
                <div class="card-footer d-flex justify-content-between">
                    <small class="text-muted">
                        Total: {{ count($campus) }} records
                    </small>
                </div>
            </div>

    <!-- ADD CAMPUS MODAL -->
<div class="modal fade" id="AddCampusModal">
    <div class="modal-dialog modal-md">
        <form method="POST" action="{{ url('store_campus') }}" id="addCampusForm">
            @csrf
            <input type="hidden" name="settings_panel" value="ManageCampusPanel">

            <div class="modal-content">
                <div class="modal-header text-dark">
                    <h5>Add Campus</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Area Code</label>
                        <input type="text" name="c_area_code" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Area Address</label>
                        <input type="text" name="c_area_address" class="form-control" required>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Report Header Path</label>
                        <input type="text" name="c_area_report_header_path" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Receipt Template</label>
                        <input type="text" name="c_receipt_template" class="form-control">
                    </div>

                    <div class="form-group  col-md-6">
                        <label>Receipt Print Option</label>
                        <input type="text" name="c_receipt_print_option" class="form-control">
                    </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button class="btn btn-outline-secondary" id="cancelBtn" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success w-50">Save Campus</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- VIEW CAMPUS MODAL -->
<div class="modal fade" id="ViewCampusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-dark">
                <h5 class="modal-title">Campus Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="view_area_code"><strong>Area Code:</strong></label>
                    <p id="view_area_code" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label for="view_area_address"><strong>Area Address:</strong></label>
                    <p id="view_area_address" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label for="view_report"><strong>Report Header Path:</strong></label>
                    <p id="view_report" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label for="view_template"><strong>Receipt Template:</strong></label>
                    <p id="view_template" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label for="view_print_option"><strong>Receipt Print Option:</strong></label>
                    <p id="view_print_option" class="form-control-plaintext"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary " data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT CAMPUS MODAL -->
<div class="modal fade" id="EditCampusModal">
    <div class="modal-dialog modal-md">
        <form method="POST" action="{{ url('update_campus') }}">
            @csrf
            <input type="hidden" name="settings_panel" value="ManageCampusPanel">

            <input type="hidden" name="c_id" id="edit_id">

            <div class="modal-content">
                <div class="modal-header text-dark">
                    <h5>Edit Campus</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Area Code</label>
                        <input type="text" name="edit_area_code" id="edit_area_code" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Area Address</label>
                        <input type="text" name="edit_area_address" id="edit_area_address" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                        <label>Report Header Path</label>
                        <input type="text" name="edit_area_report_header_path" id="edit_area_report_header_path" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Receipt Template</label>
                        <input type="text" name="edit_receipt_template" id="edit_receipt_template" class="form-control">
                    </div>

                    <div class="form-group col-md-6 ">
                        <label>Receipt Print Option</label>
                        <input type="text" name="edit_receipt_print_option" id="edit_receipt_print_option" class="form-control">
                    </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button class="btn btn-outline-secondary" id="cancelBtn" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-warning w-50">Update Campus</button>
                </div>
            </div>
        </form>
    </div>
</div>

        <!-- DELETE CAMPUS MODAL -->
        <div class="modal fade" id="DeleteCampusModal">
            <div class="modal-dialog modal-md">
                <form method="POST" action="{{ url('delete_campus') }}">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageCampusPanel">

                    <input type="hidden" name="c_id" id="delete_id">

                    <div class="modal-content">


                        <div class="modal-header bg-danger text-white">
                            <h5>Delete Campus</h5>
                        </div>

                        <div class="modal-body text-center" id="delete_message">
                            <p>Are you sure you want to delete this campus?</p>
                        </div>

                        <div class="modal-footer justify-content-between form-row">
                            <button class="btn btn-outline-secondary" id="cancelBtn" data-bs-dismiss="modal" data-dismiss="modal">Cancel</button>

                            <button class="btn btn-danger w-50">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


