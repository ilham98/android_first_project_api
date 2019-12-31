<?php

namespace App\Http\Controllers\API;

use App\Software;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SoftwareController extends Controller
{
    public function index() {
        return Software::all();
    }
}
