<?php

namespace App\Http\Controllers;

use App\SQLSRVDepartemen;
use Illuminate\Http\Request;
use App\SQLSRVKaryawan;
use Illuminate\Support\Facades\DB;

class DepartemenController extends Controller
{
    public function ajaxIndex(Request $request) {
        $departemen = SQLSRVDepartemen::where('nama', 'like', '%'.$request->q.'%')->get();
        return $departemen;
    }
}
