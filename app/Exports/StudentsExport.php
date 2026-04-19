<?php

namespace App\Exports;

use App\Models\StudentsManagementModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StudentsManagementModel::all();
    }

    /**
 * Write code on Method
 *
 * @return array
 */
public function headings(): array
{
    return [
        "ID",
        "RID",
        "SID",
        "Last Name",
        "First Name",
        "Middle Name",
        "Full Name",
        "Email",
        "Area Code",
        "College Code",
        "Course Code",
        "Year Level",
        "Term",
        "School Year",
        "Student Status",
        "Enrollment Status"
    ];
}
}
