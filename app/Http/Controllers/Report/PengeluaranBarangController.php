<?php

namespace App\Http\Controllers\Report;

use App\Exports\PermintaanPengeluaranBarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PermintaanPengeluaranBarang;
use Illuminate\Support\Facades\DB;

class PengeluaranBarangController extends Controller
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
            'no_surat',
            'kode_unit_kerja',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
            'deleted_on',
            'deleted_by'
        ];
    }

    public function index() {
        $pengeluaranBarangColumn = array_map(function($a) {
            return ['value' => $a, 'column' => $a];
        }, $this->column);
    
        return view('report.pengeluaran_barang.index', compact('pengeluaranBarangColumn'));
    }

    public function download(Request $request) {
        return Excel::download(new PermintaanPengeluaranBarangExport($request->column, collect([
            'filterByDate' => $request->filterByDate,
            'from' => $request->from,
            'to' => $request->to
        ])), 'pengeluaran_barang.xlsx');
    }
}
