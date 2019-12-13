<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aset;
use App\PermintaanPengeluaranBarang;
use App\SQLSRVKaryawan;
use App\StatusAset;
use App\StatusPengeluaranBarang;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use Auth;

class PermintaanPengeluaranBarangController extends Controller
{
    public function index() {
        return view('permintaan_pengeluaran_barang.index');
    }

    public function create() {
        $status = StatusPengeluaranBarang::all();
        return view('permintaan_pengeluaran_barang.create', compact('status'));
    }

    public function ajaxStore(Request $request) {
        $currentTime = Carbon::now();
        $itemIds = json_decode($request->itemIds);
        $statusIds = json_decode($request->statusIds);
        $permintaan_pengeluaran_barang = PermintaanPengeluaranBarang::create([
            'created_by' => Auth::user()->npk,
            'updated_by' => Auth::user()->npk,
            'no_surat' => $request->no_surat,
            'departemen_id' => $request->departemen_id
        ]);
        
        foreach($itemIds as $index => $i) {
            $aset = Aset::find($i);
            $aset->update([
                'permintaan_pengeluaran_barang_id' => $permintaan_pengeluaran_barang->id,
                'status_pengeluaran_barang_id'  => $statusIds[$index]
            ]);
        }
        
    return response('success');
    }

    public function json() {
        $permintaan_pengeluaran_barang = PermintaanPengeluaranBarang::orderBy('created_on', 'desc')->get();
        return DataTables::of($permintaan_pengeluaran_barang)
            ->addColumn('departemen', function($permintaan_pengeluaran_barang) {
                return $permintaan_pengeluaran_barang->departemen->nama;
            })->addColumn('action', function ($permintaan_pengeluaran_barang) {
                return '
                    <a href="/aset/'.$permintaan_pengeluaran_barang->id.'"><i class="pe-7s-pen text-success"></i></span>
                    <span class="btnDelete" data-id='.$permintaan_pengeluaran_barang->id.'><i class="pe-7s-trash  text-danger"></i></span>
                ';
            })->make(true); 
    }
}   
