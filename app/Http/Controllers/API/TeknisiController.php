<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SQLSRVKaryawan;
use App\User;

class TeknisiController extends Controller
{
    public function index() {
        $teknisi = User::with('karyawan')->where('role_id', 4)->get()->pluck('karyawan');

        return $teknisi;
    }
}
