<?php

namespace App\Imports;

use App\TempVendor;
use Maatwebsite\Excel\Concerns\ToModel;

class VendorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TempVendor([
            'nama' => $row[0],
            'contact_person' => $row[1]
        ]);
    }
}
