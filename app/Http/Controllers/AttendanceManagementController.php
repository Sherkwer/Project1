<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AttendanceManagementModel;
use App\Models\EventsManagementModel;
use App\Models\StudentQRCodeModel;
use App\Models\StudentsManagementModel;

class AttendanceManagementController extends Controller
{
    function ShowEventAndAttendance()
    {
        $events = EventsManagementModel::all();
        $attendance = AttendanceManagementModel::all();
        return view('AttendanceManagementView.AttendanceManagement', compact('events', 'attendance'));
    }

    function ShowCheckingOfAttendance()
    {
        $events = EventsManagementModel::all();
        return view('AttendanceManagementView.CheckingOfAttendance', compact('events'));
    }

    function store_attendance(Request $request)
    {
        // Support two modes:
        // - New JSON mode: client sends { event_id, attendance_date, fees, am_in, am_out, pm_in, pm_out, rows: [ { 'QR Code':..., 'Student ID':..., 'RFID':... }, ... ] }
        // - Legacy single-form mode (kept for backward compatibility)

        if ($request->has('rows') && is_array($request->input('rows'))) {
            $rows = $request->input('rows');
            $eventId = $request->input('event_id');
            $attendanceDate = $request->input('attendance_date') ? Carbon::parse($request->input('attendance_date'))->format('Y-m-d') : Carbon::today()->format('Y-m-d');
            $fees = $request->input('fees');
            // Determine which session flags were provided by the client.
            // We only want to update DB fields that were explicitly sent.
            $am_in_provided = $request->has('am_in');
            $am_out_provided = $request->has('am_out');
            $pm_in_provided = $request->has('pm_in');
            $pm_out_provided = $request->has('pm_out');

            DB::beginTransaction();
            try {
                // track processed student IDs so we can add missing enrolled students later
                $processedSids = [];

                foreach ($rows as $row) {
                    $student_qrcode = isset($row['QR Code']) ? trim($row['QR Code']) : (isset($row['student_qrcode']) ? trim($row['student_qrcode']) : (isset($row['qr_code']) ? trim($row['qr_code']) : null));
                    $student_rfid = isset($row['RFID']) ? trim($row['RFID']) : (isset($row['student_rfid']) ? trim($row['student_rfid']) : null);
                    $student_id = isset($row['Student ID']) ? trim($row['Student ID']) : (isset($row['student_id']) ? trim($row['student_id']) : null);

                    // skip empty rows
                    if (empty($student_qrcode) && empty($student_id) && empty($student_rfid)) {
                        continue;
                    }

                    // If QR code present but no student_id provided, try to map QR -> sid in db_students
                    if (!empty($student_qrcode) && empty($student_id)) {
                        $stu = StudentsManagementModel::where('qr_code', $student_qrcode)->first();
                        if ($stu && isset($stu->sid)) {
                            $student_id = $stu->sid;
                        }
                    }

                    // Build query that matches existing attendance by event/date and any of qr / sid / rfid
                    $query = AttendanceManagementModel::where('event_id', $eventId)->where('attendance_date', $attendanceDate);
                    if (!empty($student_qrcode)) {
                        $query->where(function($q) use ($student_qrcode, $student_id, $student_rfid) {
                            $q->where('student_qrcode', $student_qrcode);
                            if (!empty($student_id)) $q->orWhere('student_id', $student_id);
                            if (!empty($student_rfid)) $q->orWhere('student_rfid', $student_rfid);
                        });
                    } else if (!empty($student_id)) {
                        $query->where('student_id', $student_id);
                    } else if (!empty($student_rfid)) {
                        $query->where('student_rfid', $student_rfid);
                    }

                    $existing = $query->first();

                    // Base fields
                    $data = [
                        'student_qrcode' => $student_qrcode,
                        'student_rfid' => $student_rfid,
                        'student_id' => $student_id,
                        'event_id' => $eventId,
                        'attendance_date' => $attendanceDate,
                    ];

                    // Helper to read a row field case-insensitively and ignoring punctuation/spaces
                    $normalize = function($s) {
                        return strtolower(preg_replace('/[^a-z0-9]/', '', (string)$s));
                    };
                    $getRowValue = function($row, $name) use ($normalize) {
                        foreach ($row as $k => $v) {
                            if ($normalize($k) === $normalize($name)) return $v;
                        }
                        return null;
                    };
                    $parsePresence = function($val) {
                        if ($val === null) return null;
                        $v = trim((string)$val);
                        if ($v === '') return null;
                        $lv = strtolower($v);
                        if ($lv === '1' || $lv === 'true' || $lv === 'present' || $lv === 'yes' || $lv === 'y') return 1;
                        if ($lv === '0' || $lv === 'false' || $lv === 'absent' || $lv === 'no' || $lv === 'n') return 0;
                        if (is_numeric($v)) return intval($v) === 1 ? 1 : (intval($v) === 0 ? 0 : null);
                        return null;
                    };

                    // Check per-row session columns and set per-student session flags when provided in the row.
                    $sessions = ['am_in', 'am_out', 'pm_in', 'pm_out'];
                    $rowHasSessionData = false;
                    foreach ($sessions as $s) {
                        $val = $getRowValue($row, $s);
                        if ($val !== null && trim((string)$val) !== '') { $rowHasSessionData = true; break; }
                    }

                    // If the imported row contains session columns, use those values to set session flags
                    // and compute fees only for absences (value == 0). Otherwise, do not overwrite fees.
                    if ($rowHasSessionData) {
                        $absences = 0;
                        foreach ($sessions as $s) {
                            $raw = $getRowValue($row, $s);
                            $p = $parsePresence($raw);
                            if ($p === 1) {
                                $data[$s] = 1;
                            } elseif ($p === 0) {
                                $data[$s] = 0;
                                $absences++;
                            }
                            // if null => treat as N/A and omit field (do not change DB)
                        }

                        // Compute fees per-student: fee per session * absences
                        $feePerSession = is_numeric($fees) ? floatval($fees) : 0;
                        $data['fees'] = $feePerSession * $absences;
                    } else {
                        // No per-row session data — fall back to including event-level session flags only
                        if ($am_in_provided) {
                            $data['am_in'] = $request->input('am_in') ? 1 : 0;
                        }
                        if ($am_out_provided) {
                            $data['am_out'] = $request->input('am_out') ? 1 : 0;
                        }
                        if ($pm_in_provided) {
                            $data['pm_in'] = $request->input('pm_in') ? 1 : 0;
                        }
                        if ($pm_out_provided) {
                            $data['pm_out'] = $request->input('pm_out') ? 1 : 0;
                        }
                        // Do NOT include 'fees' here if row lacks session data to avoid overwriting existing values.
                    }

                    if ($existing) {
                        $existing->update($data);
                    } else {
                        AttendanceManagementModel::create($data);
                    }

                    // record processed sid if available
                    if (!empty($student_id)) {
                        $processedSids[] = $student_id;
                    } else {
                        // if no sid but we have qr_code and were able to map earlier, include mapped sid
                        if (!empty($student_qrcode)) {
                            $mapped = StudentsManagementModel::where('qr_code', $student_qrcode)->first();
                            if ($mapped && !empty($mapped->sid)) $processedSids[] = $mapped->sid;
                        }
                    }
                }

                // Add attendance records for enrolled students not present in the import
                $event = EventsManagementModel::find($eventId);
                $enrolledStudents = StudentsManagementModel::where('enroll_status', 1)->get(['sid','qr_code','rfid']);

                foreach ($enrolledStudents as $stu) {
                    // skip if this student was processed from import
                    if (in_array($stu->sid, $processedSids)) continue;

                    // check if an attendance row already exists for this student (by sid or qr or rfid)
                    $q = AttendanceManagementModel::where('event_id', $eventId)->where('attendance_date', $attendanceDate)
                        ->where(function($q2) use ($stu) {
                            $q2->where('student_id', $stu->sid);
                            if (!empty($stu->qr_code)) $q2->orWhere('student_qrcode', $stu->qr_code);
                            if (!empty($stu->rfid)) $q2->orWhere('student_rfid', $stu->rfid);
                        });

                    if ($q->exists()) continue;

                    $data = [
                        'student_qrcode' => $stu->qr_code ?? null,
                        'student_rfid' => $stu->rfid ?? null,
                        'student_id' => $stu->sid,
                        'event_id' => $eventId,
                        'attendance_date' => $attendanceDate,
                    ];

                    // determine sessions to mark absent based on checkboxes the user actually provided
                    // (only for event-active sessions). This ensures unchecked boxes do not store values.
                    $absences = 0;
                    if ($am_in_provided && $event && isset($event->am_in) && $event->am_in === 'A') { $data['am_in'] = 0; $absences++; }
                    if ($am_out_provided && $event && isset($event->am_out) && $event->am_out === 'A') { $data['am_out'] = 0; $absences++; }
                    if ($pm_in_provided && $event && isset($event->pm_in) && $event->pm_in === 'A') { $data['pm_in'] = 0; $absences++; }
                    if ($pm_out_provided && $event && isset($event->pm_out) && $event->pm_out === 'A') { $data['pm_out'] = 0; $absences++; }

                    // compute fees only for absences
                    $feePerSession = is_numeric($fees) ? floatval($fees) : 0;
                    $data['fees'] = $feePerSession * $absences;

                    AttendanceManagementModel::create($data);
                }

                DB::commit();
                return response()->json(['success' => true, 'message' => 'Attendance saved.']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        // Legacy single-record handler (kept for backward compatibility)
        $attendance = new AttendanceManagementModel();
        $attendance->attendance_id= $request->a_attendance_id;
        $attendance->studentID= $request->a_student_id;
        $attendance->eventID= $request->a_event_id;
        $attendance->attendance_date= $request->a_attendance_date;
        $attendance->am_in= $request->a_am_in;
        $attendance->am_out= $request->a_am_out;
        $attendance->pm_in= $request->a_pm_in;
        $attendance->pm_out= $request->a_pm_out;
        $attendance->fees= $request->a_fees;
        $attendance->save();

        return response()->json($attendance);
    }


    public function update_event(Request $request, $id)
    {
        $events = EventsManagementModel::where('id', $id)->first();

        if (!$events) {
            return back()->with('error', 'Event not found.');
        }

        $events->event_name = $request->event_name;
        $events->schedule = $request->schedule;
        $events->sy = $request->sy;
        $events->term = $request->term;
        $events->venue = $request->venue;
        $events->am_in = $request->am_in;
        $events->am_out = $request->am_out;
        $events->pm_in = $request->pm_in;
        $events->pm_out = $request->pm_out;
        $events->description = $request->description;
        $events->fee_perSession = $request->fee_perSession;
        $events->status = $request->status;

        $events->save();

        return back()->with('success', 'Event updated successfully.');
    }

    public function validate_import(Request $request)
    {
        // Get the array of QR codes from the request
        $qrcodes = $request->input('qrcodes', []);

        if (empty($qrcodes)) {
            return response()->json([
                'success' => false,
                'message' => 'No QR codes provided.'
            ], 400);
        }

        $validatedStudents = [];
        $invalidQrcodes = [];

        // Check each QR code against the database
        foreach ($qrcodes as $qrcode) {
            $student = StudentQRCodeModel::where('student_qrcode', trim($qrcode))->first();

            if ($student) {
                // Valid QR code - get the student info
                $validatedStudents[] = [
                    'student_qrcode' => $student->student_qrcode,
                    'student_id' => $student->student_id,
                    'fullname' => $student->fullname
                ];
            } else {
                // Invalid QR code
                $invalidQrcodes[] = $qrcode;
            }
        }

        return response()->json([
            'success' => true,
            'validatedCount' => count($validatedStudents),
            'invalidCount' => count($invalidQrcodes),
            'validatedStudents' => $validatedStudents,
            'invalidQrcodes' => $invalidQrcodes
        ]);
    }

}
