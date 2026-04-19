
    {{-- Manage Users Accounts Panel --}}

<style>
    .btn-group .btn {
        position: relative;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-group .view-user:hover::after {
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

    .btn-group .edit-user:hover::after {
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

    .btn-group .delete-user:hover::after {
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

<div id="ManageUsersAccountsPanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageUsersAccountsPanel') d-none @endunless">
    <div class="col-12 mb-3">

        <div class="card shadow-sm">

            <!-- HEADER -->
            <div class="card-header">
                <h3 class="card-title">Manage Users</h3>

                <div class="card-tools">
                    <button type="button"
                            class="btn btn-success btn-md add-modal-record"
                            data-toggle="modal"
                            data-target="#AddUserModal">
                        <i class="fas fa-plus"></i> Add New User
                    </button>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card-body table-responsive p-0" style="height: 450px">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th hidden>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>User Role</th>
                            <th>Area Code</th>
                            <th>Status</th>
                            <th class="text-center">Tools</th>
                        </tr>
                    </thead>

                    <tbody id="userTableBody">
                        @forelse($myaccount ?? [] as $user)
                        <tr>
                            <td hidden>{{ $user->id }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_role }}</td>
                            <td>{{ $user->area_code ?? 'N/A' }}</td>
                            <td>
                                @if($user->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>

                            <!-- TOOLS -->
                            <td class="btn-groups justify-content-center">
                                <!-- VIEW -->
                                <a class="btn btn-info view-btn view-user"
                                    data-id="{{ $user->id }}"
                                    data-fname="{{ $user->fname }}"
                                    data-mname="{{ $user->mname }}"
                                    data-lname="{{ $user->lname }}"
                                    data-fullname="{{ $user->fullname }}"
                                    data-email="{{ $user->email }}"
                                    data-user_role="{{ $user->user_role }}"
                                    data-area_code="{{ $user->area_code }}"
                                    data-department_id="{{ $user->department_id }}"
                                    data-organization_id="{{ $user->organization_id }}"
                                    data-is_approved="{{ $user->is_approved }}"
                                    data-is_admin="{{ $user->is_admin }}"
                                    data-toggle="modal"
                                    data-target="#ViewUserModal">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a class="btn btn-warning edit-btn edit-user"
                                    data-id="{{ $user->id }}"
                                    data-fname="{{ $user->fname }}"
                                    data-mname="{{ $user->mname }}"
                                    data-lname="{{ $user->lname }}"
                                    data-fullname="{{ $user->fullname }}"
                                    data-email="{{ $user->email }}"
                                    data-user_role="{{ $user->user_role }}"
                                    data-area_code="{{ $user->area_code }}"
                                    data-department_id="{{ $user->department_id }}"
                                    data-organization_id="{{ $user->organization_id }}"
                                    data-is_approved="{{ $user->is_approved }}"
                                    data-is_admin="{{ $user->is_admin }}"
                                    data-toggle="modal"
                                    data-target="#EditUserModal">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- DELETE -->
                                <a hidden class="btn btn-danger delete-btn delete-user"
                                    data-id="{{ $user->id }}"
                                    data-fullname="{{ $user->fullname }}"
                                    data-toggle="modal"
                                    data-target="#DeleteUserModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No user records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FOOTER -->
            <div class="card-footer d-flex justify-content-between">
                <small class="text-muted">
                    Total: {{ count($myaccount ?? []) }} records
                </small>
            </div>

        </div>

        <!-- ADD USER MODAL -->
        <div class="modal fade" id="AddUserModal">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ url('store_user') }}" id="addUserForm">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageUsersAccountsPanel">

                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5>Add User</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>First Name</label>
                                    <input type="text" name="u_fname" class="form-control" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" name="u_mname" class="form-control">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" name="u_lname" class="form-control" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Email</label>
                                    <input type="email" name="u_email" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <input type="password" name="u_password" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>User Role</label>
                                    <select name="u_user_role" class="form-control" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach($roles ?? [] as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Campus</label>
                                    <select name="u_area_code" class="form-control">
                                        <option value="">-- Select Campus --</option>
                                        @foreach($areas ?? [] as $area)
                                            <option value="{{ $area->area_code }}">{{ $area->area_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Department/College</label>
                                    <select name="u_department_id" class="form-control">
                                        <option value="">-- Select Department --</option>
                                        @foreach($colleges ?? [] as $college)
                                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Organization</label>
                                    <select name="u_organization_id" class="form-control">
                                        <option value="">-- Select Organization --</option>
                                        @foreach($organizations ?? [] as $org)
                                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Approved</label>
                                    <select name="u_is_approved" class="form-control" required>
                                        <option value="0">No</option>
                                        <option value="1" selected>Yes</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Admin</label>
                                    <select name="u_is_admin" class="form-control" required>
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="reset" class="btn btn-outline-secondary" id="cancelBtn" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button class="btn btn-success w-50">Save User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- VIEW USER MODAL -->
        <div class="modal fade" id="ViewUserModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-dark">
                        <h5 class="modal-title">User Details</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>First Name:</strong></label>
                                    <p id="view_user_fname" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Middle Name:</strong></label>
                                    <p id="view_user_mname" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Last Name:</strong></label>
                                    <p id="view_user_lname" class="form-control-plaintext"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Email:</strong></label>
                                    <p id="view_user_email" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>User Role:</strong></label>
                                    <p id="view_user_role" class="form-control-plaintext"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Campus:</strong></label>
                                    <p id="view_user_area_code" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Department:</strong></label>
                                    <p id="view_user_department_id" class="form-control-plaintext"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Organization:</strong></label>
                                    <p id="view_user_organization_id" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Approved:</strong></label>
                                    <p id="view_user_is_approved" class="form-control-plaintext"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT USER MODAL -->
        <div class="modal fade" id="EditUserModal">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ url('update_user') }}">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageUsersAccountsPanel">
                    <input type="hidden" name="u_id" id="edit_user_id">

                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5>Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>First Name</label>
                                    <input type="text" name="edit_fname" id="edit_user_fname" class="form-control" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" name="edit_mname" id="edit_user_mname" class="form-control">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" name="edit_lname" id="edit_user_lname" class="form-control" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Email</label>
                                    <input type="email" name="edit_email" id="edit_user_email" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>User Role</label>
                                    <select name="edit_user_role" id="edit_user_role" class="form-control" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach($roles ?? [] as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Campus</label>
                                    <select name="edit_area_code" id="edit_user_area_code" class="form-control">
                                        <option value="">-- Select Campus --</option>
                                        @foreach($areas ?? [] as $area)
                                            <option value="{{ $area->area_code }}">{{ $area->area_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Department/College</label>
                                    <select name="edit_department_id" id="edit_user_department_id" class="form-control">
                                        <option value="">-- Select Department --</option>
                                        @foreach($colleges ?? [] as $college)
                                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Organization</label>
                                    <select name="edit_organization_id" id="edit_user_organization_id" class="form-control">
                                        <option value="">-- Select Organization --</option>
                                        @foreach($organizations ?? [] as $org)
                                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Approved</label>
                                    <select name="edit_is_approved" id="edit_user_is_approved" class="form-control" required>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Admin</label>
                                    <select name="edit_is_admin" id="edit_user_is_admin" class="form-control" required>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="reset" class="btn btn-outline-secondary" id="cancelBtn" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button class="btn btn-info w-50">Update User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- DELETE USER MODAL -->
        <div class="modal fade" id="DeleteUserModal">
            <div class="modal-dialog modal-md">
                <form method="POST" action="{{ url('delete_user') }}">
                    @csrf
                    <input type="hidden" name="settings_panel" value="ManageUsersAccountsPanel">
                    <input type="hidden" name="u_id" id="delete_user_id">

                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5>Delete User</h5>
                        </div>

                        <div class="modal-body text-center" id="delete_user_message">
                            <p>Are you sure you want to delete this user?</p>
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



