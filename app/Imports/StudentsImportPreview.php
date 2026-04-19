<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImportPreview implements ToArray, WithHeadingRow
{
    /**
     * Collect all rows without saving to database
     */
    public function array(array $rows)
    {
        return $rows;
    }
}
