<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PermintaanPengeluaranBarang;

class PermintaanPengeluaranBarangController extends Controller
{
    public function index(Request $request) {
        $pengeluaran_barang = PermintaanPengeluaranBarang::with('unit_kerja')->orderBy('id', 'desc');
        $pengeluaran_barang = $pengeluaran_barang->where('no_surat' , 'like' , '%'.$request->q.'%');
        if($request->user_role_id == 6) {
            $user = \App\User::where('npk', $request->user_npk)->first()->karyawan;
            $karyawanNPK = \App\SQLSRVKaryawan::where('unit_kerja', $user->unit_kerja)->pluck('npk');
            $kode_unit_kerja = $user->kode_unit_kerja;
            $pengeluaran_barang = $pengeluaran_barang->whereHas('aset', function($query) use($karyawanNPK, $kode_unit_kerja){
                                            $query->where(function($query) use($karyawanNPK, $kode_unit_kerja) {
                                                $query->whereIn('npk', $karyawanNPK->toArray())->orWhereHas('permintaan_pengeluaran_barang', function($query) use($kode_unit_kerja){
                                                    $query->where('kode_unit_kerja', $kode_unit_kerja);
                                                });
                                            });
                                    })->whereDoesntHave('aset', function($query) {
                                        $query->where('approved_by_kabag_layanan_on', null);
                                    });
        } else if($request->user_role_id == 5) {
            $pengeluaran_barang = $pengeluaran_barang->whereDoesntHave('aset', function($query) {
                $query->where('kabag_layanan_in_on', null);
            });
        } else if($request->user_role_id == 2) {
            $pengeluaran_barang = $pengeluaran_barang->whereDoesntHave('aset', function($query) {
                $query->where('approved_by_kepala_unit_kerja_on', null);
            });
        } else if($request->user_role_id != 3) {
            $pengeluaran_barang = $pengeluaran_barang->whereHas('aset', function($query) {
                $query->where('teknisi_in_on', '<>', null);
            });
        } 
        
        $pengeluaran_barang = $pengeluaran_barang->paginate(20);
        return $pengeluaran_barang;
    }

    public function single($id) {
        $pengeluaran_barang = PermintaanPengeluaranBarang::with('aset.item', 'aset.aset_komputer', 'aset.aset_monitor', 'aset.aset_printer', 'unit_kerja', 'aset.teknisi')->where('id', $id)->first();
        return $pengeluaran_barang;
    }
}
