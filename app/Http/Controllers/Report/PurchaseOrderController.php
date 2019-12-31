<?php

namespace App\Http\Controllers\Report;

use App\Exports\PurchaseOrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
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
            'po_number',
            'date',
            'vendor_id',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
            'deleted_on',
            'deleted_by'
        ];
    }

    public function index() {
        $purchaseOrderColumn = array_map(function($a) {
            return ['value' => $a, 'column' => $a];
        }, $this->column);
    
        return view('report.purchase_order.index', compact('purchaseOrderColumn'));
    }

    public function download(Request $request) {
        return Excel::download(new PurchaseOrderExport($request->column, collect([
            'filterByDate' => $request->filterByDate,
            'from' => $request->from,
            'to' => $request->to
        ])), 'po.xlsx');
    }
}
