
    {{-- Manage Semester Panel --}}

    <div id="ManageSemesterPanel" class="settings-panel @unless(($activePanel ?? \App\Support\SettingsPanel::DEFAULT) === 'ManageSemesterPanel') d-none @endunless">
        <div class="col-12 mb-3">

                <div class="card shadow-sm">

                    <!-- HEADER -->
                    <div class="card-header">
                        <h3 class="card-title">Manage Semester</h3>

                        <div class="card-tools">
                            <button type="button"
                                    class="btn btn-success btn-md add-modal-record"
                                    data-toggle="modal"
                                    data-target="#AddSemesterModal">
                                <i class="fas fa-plus"></i> Add New Semester
                            </button>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="card-body table-responsive p-0" style="height: 450px">

                        <table class="table table-hover">
                            <thead >
                                <tr>
                                    <th hidden>ID</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Year</th>
                                    <th>Term</th>
                                    <th hidden>ID AY</th>
                                    <th hidden>ID Count</th>
                                    <th hidden>Is External</th>
                                    <th class="text-center">Tools</th>
                                </tr>
                            </thead>

                            <tbody id="semesterTableBody">
                                @forelse($semesters as $s)
                                <tr>

                                    <td hidden>{{ $s->id }}</td>

                                    <td>{{ $s->code }}</td>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->year }}</td>
                                    <td>{{ $s->term }}</td>
                                    <td hidden>{{ $s->id_ay }}</td>
                                    <td hidden>{{ $s->id_count }}</td>
                                    <td hidden>
                                        @if($s->is_external)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>

                                    <!-- TOOLS -->
                                    <td class="btn-groups justify-content-center">
                                            <!-- VIEW -->
                                            <a class="btn btn-info view-btn view-semester"
                                                    data-id="{{ $s->id }}"
                                                    data-code="{{ $s->code }}"
                                                    data-name="{{ $s->name }}"
                                                    data-year="{{ $s->year }}"
                                                    data-term="{{ $s->term }}"
                                                    data-id_ay="{{ $s->id_ay }}"
                                                    data-id_count="{{ $s->id_count }}"
                                                    data-is_external="{{ $s->is_external }}"
                                                    data-created_at="{{ $s->created_at }}"
                                                    data-updated_at="{{ $s->updated_at }}"
                                                    data-created_user_id="{{ $s->created_user_id }}"
                                                    data-updated_user_id="{{ $s->updated_user_id }}"
                                                    data-toggle="modal"
                                                    data-target="#ViewSemesterModal">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- EDIT -->
                                            <a class="btn btn-warning edit-btn edit-semester"
                                                    data-id="{{ $s->id }}"
                                                    data-code="{{ $s->code }}"
                                                    data-name="{{ $s->name }}"
                                                    data-year="{{ $s->year }}"
                                                    data-term="{{ $s->term }}"
                                                    data-toggle="modal"
                                                    data-target="#EditSemesterModal">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <a hidden class="btn btn-danger delete-btn delete-semester"
                                                    data-id="{{ $s->id }}"
                                                    data-name="{{ $s->name }}"
                                                    data-toggle="modal"
                                                    data-target="#DeleteSemesterModal">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        No semester records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- FOOTER -->
                    <div class="card-footer d-flex justify-content-between">
                        <small class="text-muted">
                            Total: {{ count($semesters) }} records
                        </small>
                    </div>
            </div>


            <!-- ADD SEMESTER MODAL -->
            <div class="modal fade" id="AddSemesterModal">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="{{ url('store_semester') }}" id="addSemesterForm">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageSemesterPanel">

                        <div class="modal-content">
                            <div class="modal-header text-dark">
                                <h5>Add Semester</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="row">

                                    <div class="form-group col-md-9">
                                        <label>Code</label>
                                        <input type="text" name="s_code" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Name</label>
                                        <input type="text" name="s_name" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Year</label>
                                        <input type="year" name="s_year" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-6" >
                                        <label>Term</label>
                                        <select name="s_term" class="form-control" required>
                                            <option value="" disabled selected>Select Term</option>
                                            <option value="First">1st Semester</option>
                                            <option value="Second">2nd Semester</option>
                                            <option value="Third">3rd Semester</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex " style="gap: 10px;">
                            <button type="reset" class="btn btn-outline-secondary col-md-2" id="cancelBtn" data-bs-dismiss="modal">
                                        Cancel
                            </button>

                                <button class="btn btn-success col-md-3">Save Semester</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- VIEW SEMESTER MODAL -->
            <div class="modal fade" id="ViewSemesterModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5>View Semester</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body ">
                            <div class="row">
                            <div class=" col-md-6">
                                <label>ID</label>
                                <input type="text" id="view_semester_id" class="form-control" >
                            </div>

                            <div class=" col-md-6">
                                <label>Code</label>
                                <input type="text" id="view_semester_code" class="form-control" >
                            </div>

                            <div class=" col-md-12">
                                <label>Name</label>
                                <input type="text" id="view_semester_name" class="form-control" >
                            </div>

                            <div class=" col-md-6">
                                <label>Year</label>
                                <input type="text" id="view_semester_year" class="form-control" >
                            </div>

                            <div class=" col-md-6">
                                <label>Term</label>
                                <input type="text" id="view_semester_term" class="form-control" >
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary col-md-3" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EDIT SEMESTER MODAL -->
            <div class="modal fade" id="EditSemesterModal">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="{{ url('update_semester') }}">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageSemesterPanel">

                        <input type="hidden" name="s_id" id="edit_semester_id">

                        <div class="modal-content">
                            <div class="modal-header text-dark">
                                <h5>Edit Semester</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="row">

                                    <div class="form-group col-md-9">
                                        <label>Code</label>
                                        <input type="text" name="edit_code" id="edit_semester_code" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Name</label>
                                        <input type="text" name="edit_name" id="edit_semester_name" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Year</label>
                                        <input type="year" name="edit_year" id="edit_semester_year" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Term</label>
                                        <select name="edit_term" id="edit_semester_term" class="form-control" required>
                                            <option value="First">1st Semester</option>
                                            <option value="Second">2nd Semester</option>
                                            <option value="Third">3rd Semester</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer d-flex" style="gap: 10px">
                                <button type="reset" class="btn btn-outline-secondary col-md-2" id="cancelBtn" data-bs-dismiss="modal">
                                    Cancel
                                </button>

                                <button class="btn btn-info col-md-3">Update Semester</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DELETE SEMESTER MODAL -->
            <div class="modal fade" id="DeleteSemesterModal">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="{{ url('delete_semester') }}">
                        @csrf
                        <input type="hidden" name="settings_panel" value="ManageSemesterPanel">

                        {{-- IDs must be unique on Settings page & match Settings.blade.php JS --}}
                        <input type="hidden" name="s_id" id="delete_semester_id">

                        <div class="modal-content">
                            <div class="modal-header text-dark">
                                <h5>Delete Semester</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body text-center mt-3">
                                <h5 class="text-danger ">This action cannot be undone.</h5>
                                <div id="delete_semester_message">
                                    <p>Are you sure you want to delete this semester?</p>
                                </div>
                            </div>

                            <div class="modal-footer d-flex" style="gap: 10px;">

                            <button type="reset" class="btn btn-outline-secondary col-md-2" id="cancelBtn" data-dismiss="modal">
                                Cancel
                            </button>
                                <button class="btn btn-danger col-md-3">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>



