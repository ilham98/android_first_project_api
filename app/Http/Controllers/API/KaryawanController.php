<?php

namespace App\Http\Controllers\API;

use App\SQLSRVKaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
    public function index(Request $request) {
        if($request->user_role_id == 6) {
            $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();
            $karyawan_all = SQLSRVKaryawan::where('kode_unit_kerja', $karyawan->kode_unit_kerja);
            if($request->q)
                $karyawan_all = SQLSRVKaryawan::where('nama', 'LIKE', '%'.$request->q.'%');
            $karyawan_all = $karyawan_all->get();
            return $karyawan_all;
        }
    }
}
