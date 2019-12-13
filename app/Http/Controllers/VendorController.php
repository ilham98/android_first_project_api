<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VendorImport;
use App\TempVendor;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index() {
        return view('vendor.index');
    }

    public function create() {
        return view('vendor.create');
    }

    public function store(Request $request) { 
        $request->validate([
            'nama' => 'required',
            'contact_person' => 'required'
        ]);
        Vendor::create($request->all());
        return redirect(url('vendor'))->with('success', 'Data vendor berhasil diinput');
    }

    public function edit(Request $request, $id){
        $vendor = Vendor::find($id);
        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'contact_person' => 'required'
        ]);
        $vendor = Vendor::find($id);
        $vendor->update($request->all());
        return redirect(url('vendor'))->with('success', 'Data vendor berhasil diupdate');
    }

    public function json() {
        $vendor = Vendor::all();
        return DataTables::of($vendor)
            ->addColumn('action', function ($vendor) {
                return '<a href="/vendor/'.$vendor->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })->make(true);
    }

    public function import(Request $request) 
	{

        if($request->temp == 'false') {
            DB::select(DB::raw('INSERT INTO ms_vendor (nama, contact_person)
            SELECT nama, contact_person
            FROM tmp_vendor'));
        } else {
            $this->validate($request, [
                'csvFile' => 'required|mimes:csv,xls,xlsx'
            ]);
            
            TempVendor::truncate();
    
            $file = $request->file('csvFile');
     
            $nama_file = rand().$file->getClientOriginalName();
     
            Excel::import(new VendorImport, $request->file('csvFile'));
        }
    }
    
    public function importConfirmation() {
        $vendor = TempVendor::paginate(20);
        return view('vendor.import', compact('vendor'));
    }

    public function tempUpdate($id, Request $request) {
        $vendor = TempVendor::find($id);
        $vendor->update($request->all());
    }

    public function tempDestroy($id) {
        $vendor = TempVendor::find($id);
        $vendor->delete();
    }
}
