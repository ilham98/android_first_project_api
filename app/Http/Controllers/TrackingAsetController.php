<?php

namespace App\Http\Controllers;

use App\TrackingAset;
use Illuminate\Http\Request;

class TrackingAsetController extends Controller
{
    public function index($id) {
        $tracking_aset = TrackingAset::where('aset_id', $id)->orderBy('created_on', 'desc')->get();
        if(count($tracking_aset) == 0) 
            return response('error', 500);
        return $tracking_aset;
    }
}
