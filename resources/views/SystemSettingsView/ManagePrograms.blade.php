<!-- MANAGE PROGRAMS PANEL -->

<div id="ManageProgramsPanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageProgramsPanel') d-none @endunless">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title"> <i class="fas fa-graduation-cap"></i> Manage Programs</h3>
            <div class="card-tools">
                <button class="btn btn-success" data-toggle="modal" data-target="#AddProgramModal">
                    <i class="fas fa-plus"></i> Add Program
                </button>
            </div>
        </div>

        <div class="card-body table-responsive p-0" style="height: 450px">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th hidden>ID</th>
                        <th>Area Code</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>College</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs ?? [] as $program)
                    <tr>
                        <td hidden>{{ $program->id }}</td>
                        <td>{{ $program->area_code }}</td>
                        <td>{{ $program->code }}</td>
                        <td>{{ $program->name }}</td>
                        <td>{{ $program->college_id}}</td>
                        <td>
                            <span class="badge {{ $program->status == 1 ? 'badge-success' : 'badge-secondary' }}">
                                {{ $program->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="btn-groups justify-content-center">
                            <a class="btn btn-info view-btn view-program"
                                    data-id="{{ $program->id }}"
                                    data-area_code="{{ $program->area_code }}"
                                    data-code="{{ $program->code }}"
                                    data-name="{{ $program->name }}"
                                    data-college_id="{{ $program->college_id }}"
                                    data-status="{{ $program->status }}"
                                    data-toggle="modal"
                                    data-target="#ViewProgramModal">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-warning edit-btn edit-program"
                                    data-id="{{ $program->id }}"
                                    data-area_code="{{ $program->area_code }}"
                                    data-code="{{ $program->code }}"
                                    data-name="{{ $program->name }}"
                                    data-college_id="{{ $program->college_id }}"
                                    data-status="{{ $program->status }}"
                                    data-toggle="modal"
                                    data-target="#EditProgramModal">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a hidden class="btn btn-danger delete-btn delete-program"
                                    data-id="{{ $program->id }}"
                                    data-name="{{ $program->name }}"
                                    data-toggle="modal"
                                    data-target="#DeleteProgramModal">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <div class="card-footer">
                    Total: {{ $programs->count() }}
            </div>
    </div>

    <!-- ADD PROGRAM MODAL -->
    <div class="modal fade" id="AddProgramModal">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ url('store_program') }}">
                @csrf
                <input type="hidden" name="settings_panel" value="ManageProgramsPanel">
                <div class="modal-content">
                    <div class="modal-header  text-dark">
                        <h5>Add Program</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Area Code</label>
                                <select name="area_code" class="form-control" required>
                                    <option value="">-- Select Area Code --</option>
                                    @foreach($campus as $c)
                                        <option value="{{ $c->area_code }}">{{ $c->area_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>College</label>
                                <select name="college_id" class="form-control">
                                    <option value="">-- Select College --</option>
                                    @foreach($college as $college)
                                        <option value="{{ $college->id }}">{{ $college->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-success">Save Program</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- VIEW PROGRAM MODAL -->
    <div class="modal fade" id="ViewProgramModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header text-dark">
                    <h5>View Program</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>ID</label>
                            <input type="text" id="view_program_id" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Area Code</label>
                            <input type="text" id="view_program_area_code" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Code</label>
                            <input type="text" id="view_program_code" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" id="view_program_name" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>College ID</label>
                            <input type="text" id="view_program_college_id" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Status</label>
                            <input type="text" id="view_program_status" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT PROGRAM MODAL -->
    <div class="modal fade" id="EditProgramModal">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ url('update_program') }}">
                @csrf
                <input type="hidden" name="settings_panel" value="ManageProgramsPanel">
                @method('post')
                <input type="hidden" name="id" id="edit_program_id">

                <div class="modal-content">
                    <div class="modal-header  text-dark">
                        <h5>Edit Program</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Area Code</label>
                                <select name="area_code" id="edit_program_area_code" class="form-control" required>
                                    <option value="">-- Select Area Code --</option>
                                    @foreach($campus as $c)
                                        <option value="{{ $c->area_code }}">{{ $c->area_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Code</label>
                                <input type="text" name="code" id="edit_program_code" class="form-control" required>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Name</label>
                                <input type="text" name="name" id="edit_program_name" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>College</label>
                                <select name="college_id" id="edit_program_college_id" class="form-control">
                                    <option value="">-- Select College --</option>
                                    @foreach($colleges as $college)
                                        <option value="{{ $college->id }}">{{ $college->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select name="status" id="edit_program_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-info">Update Program</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE PROGRAM MODAL -->
    <div class="modal fade" id="DeleteProgramModal">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ url('delete_program') }}">
                @csrf
                <input type="hidden" name="settings_panel" value="ManageProgramsPanel">
                <input type="hidden" name="id" id="delete_program_id">

                <div class="modal-content">
                    <div class="modal-header text-dark">
                        <h5>Delete Program</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body text-center mt-3">
                        <h5 class="text-danger ">This action cannot be undone.</h5>

                        <div id="delete_program_message"></div>
                    </div>

                    <div class="modal-footer d-flex " style="gap: 10px;">
                        <button type="button" class="btn btn-outline-secondary col-md-2" data-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-danger col-md-3">Delete Program</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
