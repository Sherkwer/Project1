<?php

namespace App\Imports;

use App\Models\StudentsManagementModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Hash;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //dd($row); // Debugging line to check the structure of $row
        $password = $row['password'] ?? null;

        return new StudentsManagementModel([
                // If your DB auto-increments id, it's safer not to force it.
                // 'id'             => $row['id'] ?? null,
                'sid'            => $row['sid'] ?? null,
                'lname'          => $row['lname'] ?? null,
                'fname'          => $row['fname'] ?? null,
                'mname'          => $row['mname'] ?? null,
                'fullname'       => $row['fullname'] ?? null,
                'email'          => $row['email'] ?? null,
                'course_code'   => $row['course_code'] ?? null,
                'year_level'     => $row['year_level'] ?? null,
                'term'           => $row['term'] ?? null,
                'sy'             => $row['sy'] ?? null,
                'student_status' => $row['student_status'] ?? null,
                'enroll_status'  => $row['enroll_status'] ?? null,
        ]);
    }

    /**
     * Write code on Method
     *
     * @return array
     */
      public function rules(): array
    {
        return [
            'rid'            => 'required',
            // Table name in this project is db_students (see StudentsManagementModel)
            'sid'            => 'required|unique:db_students',
            'lname'          => 'required',
            'fname'          => 'required',
            'fullname'       => 'required',
            'email'          => 'required|email|unique:db_students',
            'student_status' => 'required',
            'enroll_status'  => 'required',
        ];
    }
}
