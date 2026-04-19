{{-- Manage Roles Panel --}}
<style>
      .btn-group{
        display: flex;
        gap: 15px;
        border-radius: 7px;
    }
    .btn { position: relative; transition: all 0.3s ease; border-radius:7px;}
    .btn:hover { transform: scale(1.1); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
    .view-role:hover::after { content: "View"; position: absolute; bottom: -35px; left: 50%; transform: translateX(-50%); background: #17a2b8; color: rgb(0, 0, 0); padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; z-index: 1000; opacity: 1; }
     .edit-role:hover::after { content: "Edit"; position: absolute; bottom: -35px; left: 50%; transform: translateX(-50%); background: gold; color: rgb(0, 0, 0); padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; z-index: 1000; opacity: 1; }
     .delete-role:hover::after { content: "Delete"; position: absolute; bottom: -35px; left: 50%; transform: translateX(-50%); background: #dc3545; color: rgb(0, 0, 0); padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; z-index: 1000; opacity: 1; }
</style>

<div id="ManageRolesPanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageRolesPanel') d-none @endunless">
    <div class="col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Manage Roles</h3>
                <div class="card-tools">
                    <button class="btn btn-success btn-md" data-toggle="modal" data-target="#AddRoleModal"><i class="fas fa-plus"></i> Add Role</button>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height:450px;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th hidden>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td hidden>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description ?? 'N/A' }}</td>

                            <td class="btn-groups justify-content-center">
                                 <a class="btn btn-info view-btn view-role"
                                        data-id="{{ $role->id }}"
                                        data-name="{{ $role->name }}"
                                        data-description="{{ $role->description }}"
                                        data-toggle="modal"
                                        data-target="#ViewRoleModal">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a class="btn btn-warning edit-btn edit-role"
                                        data-id="{{ $role->id }}"
                                        data-name="{{ $role->name }}"
                                        data-description="{{ $role->description }}"
                                        data-toggle="modal"
                                        data-target="#EditRoleModal">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a hidden class="btn btn-danger delete-btn delete-role"
                                        data-id="{{ $role->id }}"
                                        data-name="{{ $role->name }}"
                                        data-toggle="modal"
                                        data-target="#DeleteRoleModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No role records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <small class="text-muted">Total: {{ $roles->count() }} records</small>
            </div>
        </div>

        {{-- Add Role Modal --}}
        <div class="modal fade" id="AddRoleModal">
            <div class="modal-dialog modal-xl">
                <form method="POST" action="{{ url('store_role') }}">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageRolesPanel">
                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5>Add User's Role</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Role Name</label>
                                <input type="text" name="name" class="form-control col-md-6" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer d-flex" style="gap: 10px;">
                            <button type="reset" class="btn btn-outline-secondary col-md-2" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-success col-md-3">Save Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- View Role Modal --}}
        <div class="modal fade" id="ViewRoleModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title">Role Details</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>Name:</strong></label>
                            <p id="view_role_name" class="form-control-plaintext"></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Description:</strong></label>
                            <p id="view_role_description" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary w-100" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Role Modal --}}
        <div class="modal fade" id="EditRoleModal">
            <div class="modal-dialog modal-md">
                <form method="POST" action="{{ url('update_role') }}">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageRolesPanel">
                    <input type="hidden" name="id" id="edit_role_id">
                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5>Edit Role</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Role Name</label>
                                <input type="text" name="name" id="edit_role_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="edit_role_description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-info w-50">Update Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Delete Role Modal --}}
        <div class="modal fade" id="DeleteRoleModal">
            <div class="modal-dialog modal-md">
                <form method="POST" action="{{ url('delete_role') }}">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageRolesPanel">
                    <input type="hidden" name="id" id="delete_role_id">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5>Delete Role</h5>
                        </div>
                        <div class="modal-body text-center" id="delete_role_message">
                            <p>Are you sure you want to delete this role?</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-outline-danger w-50">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
