<?php

namespace App\Http\Controllers;

use App\SQLSRVDepartemen;
use Illuminate\Http\Request;
use App\SQLSRVKaryawan;
use App\SQLSRVUnitKerja;
use Illuminate\Support\Facades\DB;

class DepartemenController extends Controller
{
    public function ajaxIndex(Request $request) {
        $departemen = SQLSRVUnitKerja::where('UnitKerja', 'like', '%'.$request->q.'%')->get();
    
    
        return $departemen;
    }
}
