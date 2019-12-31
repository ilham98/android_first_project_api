<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SQLSRVKaryawan;

class KaryawanController extends Controller
{
    public function ajaxIndex(Request $request) {
        return SQLSRVKaryawan::where('kode_unit_kerja', $request->kode_unit_kerja)->where(function($query) use($request){
            $query->where('nama', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('unit_kerja', 'LIKE', '%'.$request->q.'%');
        })->get();
    }
}
