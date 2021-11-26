<?php

namespace App\Imports;

use App\Models\Resume;
use Maatwebsite\Excel\Concerns\ToModel;

class ResumesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Resume([
            'name'     => $row[3],
        ]);
    }
}
