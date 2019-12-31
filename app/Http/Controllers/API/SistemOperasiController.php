<?php

namespace App\Http\Controllers\API;

use App\SistemOperasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SistemOperasiController extends Controller
{
    public function index(Request $request) {
        return SistemOperasi::where('jenis_sistem_operasi_id', $request->jenis_sistem_operasi_id)->get();
    }
}
