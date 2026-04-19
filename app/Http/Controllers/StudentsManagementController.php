<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentsManagementModel;
use App\Models\SystemSettingsModel\ManageRolesModel;
use App\Models\User;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Imports\StudentsImportPreview;
use Maatwebsite\Excel\Facades\Excel;
use finfo;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SystemSettingsModel\ManageCampusModel;
use App\Models\SystemSettingsModel\ManageCollegeModel;
use App\Models\SystemSettingsModel\ManageOrganizationModel;
use App\Models\SystemSettingsModel\ManageProgramsModel;

class StudentsManagementController extends Controller
{
    public function manageStudents()
    {
        $user = Auth::user();
        $roles = ManageRolesModel::whereNull('deleted_at')
            ->whereNotIn('name', ['Super Administrator', 'Administrator'])
            ->get();
        $areas = ManageCampusModel::whereNull('deleted_at')->get();
        $colleges = ManageCollegeModel::whereNull('deleted_at')->get();
        $organizations = ManageOrganizationModel::whereNull('deleted_at')->get();
        $programs = ManageProgramsModel::all();
        $student = StudentsManagementModel::all();
        return view('StudentsManagement_View.StudentsManagement', compact('user', 'student', 'areas', 'colleges', 'organizations', 'programs', 'roles'));
    }

    function showImportStudents(){
        $students = session('import_students') ?: StudentsManagementModel::all();
        return view('StudentsManagement_View.ImportStudents', compact('students'));
    }

    function showAssignQrRfid(){
        $studentsQR_RFID = StudentsManagementModel::whereNull('deleted_at')->get();
        return view('StudentsManagement_View.AssignQr_Rfid', compact('studentsQR_RFID'));
    }

    function searchStudents(Request $request)
    {
        $query = $request->input('query');
        $students = StudentsManagementModel::whereNull('deleted_at')
            ->where(function($q) use ($query) {
                $q->where('fullname', 'like', $query . '%')
                  ->orWhere('sid', 'like', $query . '%')
                  ->orWhere('email', 'like', $query . '%');
            })
            ->limit(10)
            ->get();

        if ($students->count() > 0) {
            return response()->json([
                'success' => true,
                'students' => $students->map(function($student) {
                    return [
                        'id' => $student->id,
                        'fullname' => $student->fullname,
                        'sid' => $student->sid,
                        'email' => $student->email,
                        'qr_code' => $student->qr_code,
                        'rfid' => $student->rfid
                    ];
                })
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'No students found']);
        }
    }

    function assignQrRfid(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:db_students,id',
            'qr_code' => 'nullable|string',
            'rfid' => 'nullable|string',
        ]);

        $student = StudentsManagementModel::findOrFail($request->student_id);
        $student->qr_code = $request->qr_code;
        $student->rfid = $request->rfid;
        $student->save();

        return response()->json(['success' => true, 'message' => 'QR Code and RFID assigned successfully']);
    }
    function showStudentProfile($id)
    {
        $student = StudentsManagementModel::findOrFail($id);
        $roles = ManageRolesModel::whereNull('deleted_at')->get();
        $areas = ManageCampusModel::whereNull('deleted_at')->get();
        $colleges = ManageCollegeModel::whereNull('deleted_at')->get();
        $organizations = ManageOrganizationModel::whereNull('deleted_at')->get();
        $programs = ManageProgramsModel::all();

        return view('StudentsManagement_View.StudentProfile', compact('student', 'roles', 'areas', 'colleges', 'organizations', 'programs'));
    }

        function store_student(Request $request)
        {
            $request->validate([
                's_sid' => 'required',
                's_lname' => 'required',
                's_fname' => 'required',
                's_email' => 'required|email',
                's_rid' => 'required',
                's_course_code' => 'required',
                's_year_level' => 'required',
            ]);

            $student = new StudentsManagementModel();
            $student->rid= $request->s_rid;
            $student->sid= $request->s_sid;
            $student->lname= $request->s_lname;
            $student->fname= $request->s_fname;
            $student->mname= $request->s_mname;
            $fullname = trim($request->s_fname . ' ' . ($request->s_mname ?? '') . ' ' . $request->s_lname);
            $student->fullname= $fullname;
            $student->area_code= $request->s_area_code;
            $student->email= $request->s_email;
            $student->college_code= $request->s_college_code;
            $student->organization_id = $request->s_organization_id;
            $student->course_code= $request->s_course_code;
            $student->year_level= $request->s_year_level;
            $student->term= $request->s_term ?? '';
            $student->sy= $request->s_sy ?? '';
            $student->password= $request->s_password ?? null;
            $student->student_status= $request->s_student_status;
            $student->enroll_status= $request->s_enroll_status;
            $student->save();

            return back()->with('success', 'Student added successfully.');
        }

        public function update_student(Request $request)
        {
            // match names used in the "Edit Student" modal (prefix "e_")
            $request->validate([
                'e_lname' => 'required',
                'e_fname' => 'required',
                'e_email' => 'required|email'
            ]);

            $student = StudentsManagementModel::where('id', $request->e_id)->first();

            if (!$student) {
                return back()->with('error', 'Student not found.');
            }

            // update fields using e_ prefix
            $student->rid = $request->e_rid;
            $student->sid = $request->e_sid;
            $student->lname = $request->e_lname;
            $student->fname = $request->e_fname;
            $student->mname = $request->e_mname;
            $student->fullname = $request->e_fullname;
            $student->email = $request->e_email;
            $student->area_code = $request->e_area_code;
            $student->college_code = $request->e_college_code;
            $student->course_code = $request->e_course_code;
            $student->year_level = $request->e_year_level;
            $student->term = $request->e_term;
            $student->sy = $request->e_sy;
            $student->student_status = $request->e_student_status;
            $student->enroll_status = $request->e_enroll_status == 'Active' ? 1 : 0;

            $student->save();

            return back()->with('success', 'Student updated successfully.');
        }

        function delete_student(Request $request)
        {
            $student = StudentsManagementModel::where('id', $request->d_id)->first();

            if (!$student) {
                return back()->with('error', 'Student not found.');
            }

            $student->delete();

            return back()->with('success', 'Student deleted successfully.');
        }


    // Import students from Excel/CSV - Load file for preview
    function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            // Load file data without saving to database
            $rows = Excel::toArray(new StudentsImportPreview, $request->file('file'));

            if (empty($rows) || empty($rows[0])) {
                return back()->with('error', 'The file is empty or invalid.');
            }

            // Store in session for preview
            session(['import_students' => $rows[0]]);

            return back()->with('info', 'File loaded successfully. Review the data below before confirming import.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error reading file: ' . $e->getMessage());
        }
    }


    // Export students to Excel
    public function exportStudents()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    // Download student template
    public function downloadTemplate()
    {
        $headers = [
             'sid', 'lname', 'fname', 'mname', 'fullname', 'email', 'year_level', 'term', 'sy', 'student_status', 'enroll_status'
        ];

        $data = [
            $headers, // Header row
            ['', '', '', '', '', '', '', '', '', '', ''] // Empty row for example
        ];

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        }, 'student_import_template.xlsx');
    }

    // Save imported students - Validate for duplicates and save
    public function saveImport(Request $request)
    {
        try {
            $importData = session('import_students');
            if (!$importData || count($importData) === 0) {
                return back()->with('error', 'No import data found. Please upload a valid file first.');
            }

            // Collect Student IDs and Emails
            $sids = array_filter(array_map(function ($row) {
                return $row['sid'] ?? null;
            }, $importData));

            $emails = array_filter(array_map(function ($row) {
                return $row['email'] ?? null;
            }, $importData));

            // Check for duplicate Student IDs in database
            $existingSids = StudentsManagementModel::whereIn('sid', $sids)->pluck('sid')->toArray();
            if (!empty($existingSids)) {
                return back()->with('error', '❌ Duplicate Student ID(s) found in database: ' . implode(', ', $existingSids) . '. Please correct and try again.');
        }

        // Check for duplicate emails in database
        $existingEmails = StudentsManagementModel::whereIn('email', $emails)->pluck('email')->toArray();
        if (!empty($existingEmails)) {
            return back()->with('error', '❌ Duplicate Email(s) found in database: ' . implode(', ', $existingEmails) . '. Please correct and try again.');
        }

        // Check for duplicate emails within the import file itself
        $duplicateEmails = array_diff_assoc($emails, array_unique($emails));
        if (!empty($duplicateEmails)) {
            return back()->with('error', '❌ Duplicate email(s) found in the import file: ' . implode(', ', array_unique($duplicateEmails)) . '. Please correct and try again.');
        }

        $imported = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($importData as $rowData) {
                try {
                    $student = new StudentsManagementModel();
                    $student->rid = $rowData['rid'] ?? null;
                    $student->sid = $rowData['sid'] ?? null;
                    $student->lname = $rowData['lname'] ?? null;
                    $student->fname = $rowData['fname'] ?? null;
                    $student->mname = $rowData['mname'] ?? null;
                    $student->fullname = $rowData['fullname'] ?? null;
                    $student->email = $rowData['email'] ?? null;
                    $student->area_code = $rowData['area_code'] ?? null;
                    $student->college_code = $rowData['college_code'] ?? null;
                    $student->course_code = $rowData['course_code'] ?? null;
                    $student->year_level = $rowData['year_level'] ?? null;
                    $student->term = $rowData['term'] ?? null;
                    $student->sy = $rowData['sy'] ?? null;
                    $student->student_status = $rowData['student_status'] ?? null;
                    $student->enroll_status = $rowData['enroll_status'] ?? null;
                    $student->save();

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Row with Student ID ' . ($rowData['sid'] ?? 'unknown') . ': ' . $e->getMessage();
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
            } else {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while saving imported students: ' . $e->getMessage());
        }

        session()->forget('import_students');

        if (!empty($errors)) {
            return back()->with('error', 'Import completed with errors: ' . implode(' | ', $errors));
        }

        return back()->with('success', "✅ Successfully imported $imported students into the database.");
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error during import process: ' . $e->getMessage());
        }
    }

    // Cancel import
    public function cancelImport(Request $request)
    {
        session()->forget('import_students');
        return back()->with('info', 'Import cancelled.');
    }

}
