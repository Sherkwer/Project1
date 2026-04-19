    {{-- Manage Organization Panel --}}
<style>
    .btn-group .btn {
        position: relative;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-group .view-org:hover::after {
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

    .btn-group .edit-org:hover::after {
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

    .btn-group .delete-org:hover::after {
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
<div id="ManageOrganizationPanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageOrganizationPanel') d-none @endunless">
    <div class="col-12 mb-3">
            <div class="card shadow-sm">

                <!-- HEADER -->
                <div class="card-header">
                    <h3 class="card-title">Manage Organization</h3>

                    <div class="card-tools">
                        <button class="btn btn-success btn-md"
                                data-toggle="modal"
                                data-target="#AddOrganizationModal">
                            <i class="fas fa-plus"></i> Add Organization
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="card-body table-responsive p-0" style="height: 450px">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Campus</th>
                                <th>College</th>
                                <th class="text-center">Tools</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($organizations as $org)
                            <tr>
                                <td hidden>{{ $org->id }}</td>
                                <td>{{ $org->name }}</td>
                                <td>{{ $org->description }}</td>
                                <td>{{ $org->area_code ?? 'N/A' }}</td>
                                <td>{{ $org->college_id ?? 'N/A' }}</td>

                                <td class="btn-groups justify-content-center">
                                    <!-- VIEW -->
                                    <button class="btn btn-info view-btn view-org"
                                        data-id="{{ $org->id }}"
                                        data-name="{{ $org->name }}"
                                        data-description="{{ $org->description }}"
                                        data-area_code="{{ $org->area_code ?? 'N/A' }}"
                                        data-college_id="{{ $org->college_id ?? 'N/A' }}"
                                        data-toggle="modal"
                                        data-target="#ViewOrganizationModal">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- EDIT -->
                                    <button class="btn btn-warning edit-btn edit-org"
                                        data-id="{{ $org->id }}"
                                        data-name="{{ $org->name }}"
                                        data-description="{{ $org->description }}"
                                        data-campus="{{ $org->area_code ?? 'N/A' }}"
                                        data-college="{{ $org->college_id ?? 'N/A' }}"
                                        data-toggle="modal"
                                        data-target="#EditOrganizationModal">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- DELETE -->
                                    <button hidden class="btn btn-danger delete-btn delete-org"
                                        data-id="{{ $org->id }}"
                                        data-name="{{ $org->name }}"
                                        data-toggle="modal"
                                        data-target="#DeleteOrganizationModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    No organization records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- FOOTER -->
                <div class="card-footer">
                    Total: {{ $organizations->count() }}
                </div>
            </div>

            <!-- ADD ORGANIZATION MODAL -->
            <div class="modal fade" id="AddOrganizationModal">
                <div class="modal-dialog">
                    <form method="POST" action="{{ url('store_organization') }}">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageOrganizationPanel">

                        <div class="modal-content">

                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Add Organization</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Organization Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Campus</label>
                                    <select name="campus_id" class="form-control">
                                        <option value="">-- Select Campus --</option>
                                        @foreach($campus as $c)
                                            <option value="{{ $c->area_code }}">{{ $c->area_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>College</label>
                                    <select name="college_id" class="form-control">
                                        <option value="">-- Select College --</option>
                                        @foreach($college as $col)
                                            <option value="{{ $col->id }}">{{ $col->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>

                            <div class="modal-footer">
                                <button type="reset" class="btn btn-outline-secondary w-50">Cancel</button>
                                <button type="submit" class="btn btn-success w-50">Save</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- VIEW ORGANIZATION MODAL -->
            <div class="modal fade" id="ViewOrganizationModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header bg-secondary text-white">
                            <h5 class="modal-title">Organization Details</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="view_org_name"><strong>Name:</strong></label>
                                <p id="view_org_name" class="form-control-plaintext"></p>
                            </div>

                            <div class="form-group">
                                <label for="view_org_description"><strong>Description:</strong></label>
                                <p id="view_org_description" class="form-control-plaintext"></p>
                            </div>

                            <div class="form-group">
                                <label for="view_org_campus"><strong>Campus:</strong></label>
                                <p id="view_org_campus" class="form-control-plaintext"></p>
                            </div>

                            <div class="form-group">
                                <label for="view_org_college"><strong>College:</strong></label>
                                <p id="view_org_college" class="form-control-plaintext"></p>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary w-100" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>


            <!-- EDIT ORGANIZATION MODAL -->
            <div class="modal fade" id="EditOrganizationModal">
                <div class="modal-dialog">
                    <form method="POST" action="{{ url('update_organization') }}">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageOrganizationPanel">

                        <input type="hidden" name="id" id="edit_org_id">

                        <div class="modal-content">

                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">Edit Organization</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="edit_org_name">Organization Name</label>
                                    <input type="text" name="edit_name" id="edit_org_name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="edit_org_description">Description</label>
                                    <textarea name="edit_description" id="edit_org_description" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="edit_org_campus">Campus</label>
                                    <select name="edit_campus" id="edit_org_campus" class="form-control">
                                        <option value="">-- Select Campus --</option>
                                        @foreach($campus as $c)
                                            <option value="{{ $c->area_code }}">{{ $c->area_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="edit_org_college">College</label>
                                    <select name="edit_college" id="edit_org_college" class="form-control">
                                        <option value="">-- Select College --</option>
                                        @foreach($college as $col)
                                            <option value="{{ $col->id }}">{{ $col->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer d-flex justify-content-between" >
                                <button type="reset" class="btn btn-outline-secondary ">Cancel</button>
                                <button type="submit" class="btn btn-info w-50">Update</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- DELETE ORGANIZATION MODAL -->
            <div class="modal fade" id="DeleteOrganizationModal">
                <div class="modal-dialog">
                    <form method="POST" action="{{ url('delete_organization') }}">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageOrganizationPanel">

                        <input type="hidden" name="id" id="delete_org_id">

                        <div class="modal-content">

                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Delete Organization</h5>
                            </div>

                            <div class="modal-body text-center" id="delete_org_message">
                                <p>Are you sure you want to delete this organization?</p>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-danger w-50">Delete</button>
                                <button type="button" class="btn btn-outline-secondary w-50" data-dismiss="modal">
                                    Cancel
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
