<?php

namespace App\Http\Controllers;

use App\Aset;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxActionController extends Controller
{
    public function getItemAndStockForAsset(Request $request) {
        $purchase_order_id = $request->purchase_order_id;
        $item = DB::select(DB::raw("
            SELECT tr_item.id, 
            tr_item.nama, 
            tr_item.item_order,
            (stok - (SELECT COUNT(id) FROM tr_aset WHERE item_id = tr_item.id 
            AND tr_aset.registration_number IS NOT NULL)) AS stok 
            FROM tr_item 
            WHERE stok > 0 
                AND 
                purchase_order_id = $purchase_order_id
                AND tr_item.nama LIKE '%".$request->q."%'
        "));
        return $item;
    }

    public function getItemAndStockForPengeluaranBarang(Request $request) {
        $purchase_order_id = $request->purchase_order_id;
        $asetIds = $request->asetIds ? implode(',', json_decode($request->asetIds)) : '';
        $item = DB::select(DB::raw("
        SELECT tr_aset.registration_number, tr_aset.id, item_id, nama, COUNT(tr_aset.id) AS stok FROM tr_aset, tr_item
            WHERE item_id = tr_item.id
                AND permintaan_pengeluaran_barang_id IS NULL
            ".(strlen($asetIds) > 0 ? " AND tr_aset.id NOT IN ($asetIds) " : " ")."
            AND tr_aset.deleted_on IS NULL
            AND 
                purchase_order_id = $purchase_order_id
                AND tr_item.nama LIKE '%".$request->q."%'
                
            GROUP BY item_id
            
        "));

        return $item;

    }
}
