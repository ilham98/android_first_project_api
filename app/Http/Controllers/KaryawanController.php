<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SQLSRVKaryawan;

class KaryawanController extends Controller
{
    public function ajaxIndex(Request $request) {
        return SQLSRVKaryawan::where('departemen_id', $request->departemen_id)->get();
    }
}
