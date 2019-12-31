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

    public function edit($id) {
        $status = StatusPengeluaranBarang::all();
        $p_barang = PermintaanPengeluaranBarang::find($id);
        $aset = $p_barang->aset()->with('tipe', 'item.purchase_order', 'status')->get();

        return view('permintaan_pengeluaran_barang.edit', compact('status', 'p_barang', 'aset'));
    }

    public function ajaxStore(Request $request) {
        $currentTime = Carbon::now();
        $itemIds = json_decode($request->itemIds);
        $statusIds = json_decode($request->statusIds);
        $tanggalMulaiPeminjaman = json_decode($request->tanggalMulaiPeminjaman);
        $tanggalSelesaiPeminjaman = json_decode($request->tanggalSelesaiPeminjaman);
        $permintaan_pengeluaran_barang = PermintaanPengeluaranBarang::create([
            'created_by' => Auth::user()->npk,
            'updated_by' => Auth::user()->npk,
            'no_surat' => $request->no_surat,
            'kode_unit_kerja' => $request->departemen_id
        ]);
        
        foreach($itemIds as $index => $i) {
            $aset = Aset::find($i);
            $aset->update([
                'permintaan_pengeluaran_barang_id' => $permintaan_pengeluaran_barang->id,
                'status_pengeluaran_barang_id'  => $statusIds[$index],
                'kasie_layanan_in_on' => \Carbon\Carbon::now(),
                'kasie_layanan_in_by' => \Auth::user()->npk,
                'peminjaman_start_date' => $tanggalMulaiPeminjaman[$index],
                'peminjaman_end_date' => $tanggalSelesaiPeminjaman[$index]
            ]);
        }
        
        $rendal_ids = \App\User::where('role_id', 2)->get();
        $rendal_ids = $rendal_ids->map(function($r) {
            return $r->id;
        })->toArray();
        
        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        sendNotification(
            "Permintaan Pengeluaran Barang", 
            "Permintaan Pengeluaran Barang Oleh ".\Auth::user()->karyawan->nama, 
            $user_ids, 
            1,
            $permintaan_pengeluaran_barang->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function ajaxUpdate($permintaan_pengeluaran_barang_id, Request $request) {
        $permintaan_pengeluaran_barang = PermintaanPengeluaranBarang::find($permintaan_pengeluaran_barang_id);
        $permintaan_pengeluaran_barang->update([
            'created_by' => Auth::user()->npk,
            'updated_by' => Auth::user()->npk,
            'no_surat' => $request->no_surat,
            'kode_unit_kerja' => $request->departemen_id
        ]);

        return $permintaan_pengeluaran_barang;
    }

    public function ajaxDestroy($permintaan_pengeluaran_barang_id) {
        $permintaan_pengeluaran_barang = PermintaanPengeluaranBarang::find($permintaan_pengeluaran_barang_id);
        $isPermintaanBarangHasAsetYangDiTeknisi = PermintaanPengeluaranBarang::where('id', $permintaan_pengeluaran_barang_id)
                                                   ->whereHas('aset', function($query) {
                                                        $query->where('teknisi_in_on', '<>', null);
                                                   })->get();
                
        if($isPermintaanBarangHasAsetYangDiTeknisi->count() > 0)
            return response('error', 500);
        
        $aset_ids =  $permintaan_pengeluaran_barang->aset()->pluck('id');
        Aset::whereIn('id', $aset_ids)->update([
            'permintaan_pengeluaran_barang_id' => null
        ]);
        
        $permintaan_pengeluaran_barang->update([
            'deleted_on' => \Carbon\Carbon::now(),
            'deleted_by' => \Auth::user()->npk
        ]);
    }

    public function ajaxAsetStore($permintaan_pengeluaran_barang_id, $id, Request $request) {
        $aset = Aset::find($id);
        $aset->update([
            'permintaan_pengeluaran_barang_id' => $permintaan_pengeluaran_barang_id,
            'status_pengeluaran_barang_id' => $request->status_id,
            'kasie_layanan_in_on' => \Carbon\Carbon::now(),
            'kasie_layanan_in_by' => \Auth::user()->npk
            ]);

        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        sendNotification(
            "Permintaan Pengeluaran Barang", 
            "Permintaan Pengeluaran Barang Oleh ".\Auth::user()->karyawan->nama, 
            $user_ids, 
            7,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }
    
    public function ajaxAsetUpdate($permintaan_pengeluaran_barang_id, $id, Request $request) {
        if($request->prevAsetId != $request->aset_id) {
            $aset = Aset::find($request->prevAsetId );
            $aset->update(['permintaan_pengeluaran_barang_id' => null]);
        }
        $aset = Aset::find($request->aset_id);
        
        $aset->update([
            'permintaan_pengeluaran_barang_id' => $permintaan_pengeluaran_barang_id,
            'status_pengeluaran_barang_id' => $request->status_id
        ]);

        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        sendNotification(
            "Update data aset pada permintaan Pengeluaran Barang", 
            "Update data aset pada permintaan Pengeluaran Barang Oleh ".\Auth::user()->karyawan->nama, 
            $user_ids, 
            7,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function ajaxAsetDestroy($permintaan_pengeluaran_barang_id, $id) {
        $aset = Aset::find($id);
        if($aset->teknisi_in_on != null)
            return response('error', 500);
        $aset->update(['permintaan_pengeluaran_barang_id' => null]);
        
        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        sendNotification(
            "Penghapusan aset pada permintaan Pengeluaran Barang", 
            "Penghapusan aset pada Permintaan Pengeluaran Barang Oleh ".\Auth::user()->karyawan->nama, 
            $user_ids, 
            7,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function json() {
        $permintaan_pengeluaran_barang = PermintaanPengeluaranBarang::orderBy('id', 'desc')->get();
        return DataTables::of($permintaan_pengeluaran_barang)
            ->addColumn('departemen', function($permintaan_pengeluaran_barang) {
                return $permintaan_pengeluaran_barang->unit_kerja->UnitKerja;
            })->addColumn('action', function ($p) {
                return '
                    <a href="/permintaan-pengeluaran-barang/'.$p->id.'/edit" ><i class="pe-7s-pen text-success"></i></a>
                    <span class="btnDelete" data-no_surat="'.$p->no_surat.'" data-id="'.$p->id.'"><i class="pe-7s-trash  text-danger"></i></span>
                ';
            })->make(true); 
    }
}   
