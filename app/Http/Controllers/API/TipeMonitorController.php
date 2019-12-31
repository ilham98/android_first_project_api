<?php

namespace App\Http\Controllers\API;

use App\TipeMonitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TipeMonitorController extends Controller
{
    public function index() {
        return TipeMonitor::all();
    }
}
