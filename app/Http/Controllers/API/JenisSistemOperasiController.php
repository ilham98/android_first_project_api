<?php

namespace App\Http\Controllers\API;

use App\JenisSistemOperasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisSistemOperasiController extends Controller
{
    public function index() {
        return JenisSistemOperasi::where('id', '<>', 0)->get();
    }
}
