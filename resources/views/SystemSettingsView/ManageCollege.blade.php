 {{-- Manage College Panel --}}
<style>
    .btn-group .btn {
        position: relative;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-group .view-college:hover::after {
        content: "View";
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        background: #007bff;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1000;
        opacity: 1;
        animation: fadeIn 0.3s ease;
    }

    .btn-group .edit-college:hover::after {
        content: "Edit";
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        background: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1000;
        opacity: 1;
        animation: fadeIn 0.3s ease;
    }

    .btn-group .delete-college:hover::after {
        content: "Delete";
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        background: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1000;
        opacity: 1;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(-50%) translateY(-5px); }
        to { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
</style>
    <div id="ManageCollegePanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageCollegePanel') d-none @endunless">
        <div class="col-12 mb-3">

            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header">
                    <h3 class="card-title">Manage College</h3>

                    <div class="card-tools">
                        <button type="button"
                                class="btn btn-success btn-md add-modal-record"
                                data-toggle="modal"
                                data-target="#AddCollegeModal">
                            <i class="fas fa-plus"></i> Add New College
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="card-body table-responsive p-0" style="height: 450px">
                    <table class="table table-hover">
                        <thead >
                            <tr>
                                <th hidden>ID</th>
                                <th style="width: 120px;">Area Code</th>
                                <th>College Name</th>
                                <th hidden>Prefix</th>
                                <th>Head Officer</th>
                                <th class="text-center">Tools</th>
                            </tr>
                        </thead>

                        <tbody id="collegeTableBody">
                            @forelse($college as $c)
                            <tr>

                                <td hidden>{{ $c->id }}</td>
                                <td>{{ $c->area_code }}</td>
                                <td>{{ $c->name }}</td>
                                <td hidden >{{ $c->prefix }}</td>
                                <td>{{ $c->head_officer }}</td>

                                <!-- TOOLS -->
                                <td class="btn-groups justify-content-center">
                                        <!-- VIEW -->
                                        <a class="btn btn-info view-btn view-college"
                                            data-id="{{ $c->id }}"
                                            data-area_code="{{ $c->area_code }}"
                                            data-name="{{ $c->name }}"
                                            data-prefix="{{ $c->prefix }}"
                                            data-head_officer="{{ $c->head_officer }}"
                                            data-toggle="modal"
                                            data-target="#ViewCollegeModal">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a class="btn btn-warning edit-btn edit-college"
                                            data-id="{{ $c->id }}"
                                            data-area_code="{{ $c->area_code }}"
                                            data-name="{{ $c->name }}"
                                            data-prefix="{{ $c->prefix }}"
                                            data-head_officer="{{ $c->head_officer }}"
                                            data-toggle="modal"
                                            data-target="#EditCollegeModal">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <a hidden class="btn btn-danger delete-btn delete-college"
                                                data-id="{{ $c->id }}"
                                                data-name="{{ $c->name }}"
                                                data-toggle="modal"
                                                data-target="#DeleteCollegeModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No college records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- FOOTER -->
                <div class="card-footer d-flex justify-content-between">
                    <small class="text-muted">
                        Total: {{ $college->count() }} records
                    </small>
                </div>

        </div>



        <!-- ADD COLLEGE MODAL -->
        <div class="modal fade" id="AddCollegeModal" >
            <div class="modal-dialog modal-md ">
                <form method="POST" action="{{ url('store_college') }}" id="addCollegeForm">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageCollegePanel">

                    <div class="modal-content">
                        <div class="modal-header  text-dark">
                            <h5>Add College</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <label>Area Code</label>
                                <select name="c_area_code" class="form-control" required>
                                    <option value="">-- Select Area Code --</option>
                                    @foreach($campus as $c)
                                        <option value="{{ $c->area_code }}">{{ $c->area_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>College Name</label>
                                <input type="text" name="c_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Prefix</label>
                                <input type="text" name="c_prefix" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Head Officer</label>
                                <input type="text" name="c_head_officer" class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="reset" class="btn btn-outline-secondary" id="cancelBtn" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button class="btn btn-success w-50">Save College</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- VIEW COLLEGE MODAL -->
        <div class="modal fade" id="ViewCollegeModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-dark">
                        <h5 class="modal-title">College Details</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="view_college_area_code"><strong>Area Code:</strong></label>
                            <p id="view_college_area_code" class="form-control-plaintext"></p>
                        </div>
                        <div class="form-group">
                            <label for="view_college_name"><strong>College Name:</strong></label>
                            <p id="view_college_name" class="form-control-plaintext"></p>
                        </div>
                        <div class="form-group">
                            <label for="view_college_prefix"><strong>Prefix:</strong></label>
                            <p id="view_college_prefix" class="form-control-plaintext"></p>
                        </div>
                        <div class="form-group">
                            <label for="view_college_head_officer"><strong>Head Officer:</strong></label>
                            <p id="view_college_head_officer" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary " data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT COLLEGE MODAL -->
        <div class="modal fade" id="EditCollegeModal">
            <div class="modal-dialog modal-md">
                <form method="POST" action="{{ url('update_college') }}">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageCollegePanel">

                    {{-- Must match ManageCollegeController: c_id --}}
                    <input type="hidden" name="c_id" id="edit_college_id">

                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5>Edit College</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <label for="edit_college_area_code">Area Code</label>
                                <select name="edit_area_code" id="edit_college_area_code" class="form-control" required>
                                    <option value="">-- Select Area Code --</option>
                                    @foreach($campus as $c)
                                        <option value="{{ $c->area_code }}">{{ $c->area_name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="edit_college_name">College Name</label>
                                <input type="text" name="edit_name" id="edit_college_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="edit_college_prefix">Prefix</label>
                                <input type="text" name="edit_prefix" id="edit_college_prefix" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="edit_college_head_officer">Head Officer</label>
                                <input type="text" name="edit_head_officer" id="edit_college_head_officer" class="form-control">
                            </div>

                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="reset" class="btn btn-outline-secondary" id="cancelBtn" data-bs-dismiss="modal">
                                    Cancel
                            </button>
                            <button class="btn btn-info w-50">Update College</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- DELETE COLLEGE MODAL -->
            <div class="modal fade" id="DeleteCollegeModal">
                <div class="modal-dialog modal-md">
                    <form method="POST" action="{{ url('delete_college') }}">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageCollegePanel">

                        <input type="hidden" name="c_id" id="delete_college_id">

                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5>Delete College</h5>
                            </div>

                            <div class="modal-body text-center" id="delete_college_message">
                                <p>Are you sure you want to delete this college?</p>
                            </div>

                            <div class="modal-footer d-flex justify-content-between">
                                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-outline-danger w-50">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



