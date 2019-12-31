<?php

namespace App\Http\Controllers\Report;

use App\Exports\AsetExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AsetReportController extends Controller
{
    public function __construct()
    {
        // $this->column = DB::select(DB::raw("    
        //     SELECT COLUMN_NAME
        //     FROM INFORMATION_SCHEMA.COLUMNS
        //     WHERE TABLE_NAME = 'tr_aset'
        //     ORDER BY ORDINAL_POSITION
        // "));

        $this->column = [
            'id',
            'registration_number',
            'item_id',
            'tipe_id',
            'status_id',
            'npk',
            'permintaan_pengeluaran_barang_id',
            'status_pengeluaran_barang_id',
            'teknisi_npk',
            'pic',
            'catatan',
            'klasifikasi_aset',
            'kasie_layanan_in_on',
            'kasie_layanan_in_by',
            'teknisi_in_on',
            'teknisi_in_by',
            'kontrol_aset_in_on',
            'kontrol_aset_in_by',
            'kabag_layanan_in_on',
            'kabag_layanan_in_by',
            'approved_by_kabag_layanan_on',
            'approved_by_kabag_layanan_by',
            'rejected_by_kabag_layanan_on',
            'rejected_by_kabag_layanan_by',
            'approved_by_kepala_unit_kerja_on',
            'approved_by_kepala_unit_kerja_by',
            'barang_diserahkan_ke_pengguna_on',
            'barang_diserahkan_ke_pengguna_by',
            'signature_url',
            'nama_pengambil_barang',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
            'deleted_on',
            'deleted_by',    
            'item_nama'
        ];
    }

    public function index() {
        $asetColumn = array_map(function($a) {
            return ['value' => $a, 'column' => $a];
        }, $this->column);
    
        return view('report.aset.index', compact('asetColumn'));
    }

    public function download(Request $request) {
        return Excel::download(new AsetExport($request->column, collect([
            'filterByDate' => $request->filterByDate,
            'from' => $request->from,
            'to' => $request->to
        ])), 'aset.xlsx');
    }
}
