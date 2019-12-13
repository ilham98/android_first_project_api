<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aset;
use App\Item;
use App\PurchaseOrder;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function ajaxIndex(Request $request) {
        $po_number = $request->po_number;
        $except = $request->except ? json_decode($request->except) : [];
        
        // if($request->group == 'true') {
        //     $aset = Aset::select(DB::raw('tr_aset.id, nama, count(nama) as jumlah, po_number'))->join('tr_purchase_order', 'tr_aset.purchase_order_id', '=', 'tr_purchase_order.id')->whereHas('purchase_order', function($query) use ($po_number) {
        //         $query->where('po_number', $po_number);
        //     })->where('registration_number', '<>', null)->whereNotIn('tr_aset.id', $except)->where('permintaan_pengeluaran_barang_in_on', null)->groupBy('nama')->get();

        //     return $aset;
        // }
        
        // $aset = Aset::where('registration_number', null)->whereHas('purchase_order', function($query) use ($po_number) {
        //     $query->where('po_number', $po_number);
        // })->groupBy('nama')->get();

        $item = Item::whereHas('purchase_order', function($query) use($po_number) {
            $query->where('po_number', $po_number);
        })->where(function ($query) use($request){
            $query->where('nama', 'like', '%'.$request->q.'%')
                  ->orWhere('item_order', 'like', '%'.$request->q.'%');
        })->get();

        return $item;
    }

    public function ajaxSingle($id, Request $request) {
        $aset = Aset::with('tipe')->where('id', $id)->first();
        return $aset;
    }

    public function ajaxStore(Request $request) {
        $item = Item::create($request->all());
        $purchase_order = $item->purchase_order;
        foreach($purchase_order->item as $index => $i) {
            $i->update([
                'item_order' => 'item '.($index + 1)
            ]);
        }
        
        return $item;
    }

    public function ajaxDestroy($id) {
        $item = Item::find($id);
        $purchase_order = $item->purchase_order;
        $item->delete();

        
        if($purchase_order->item->count() == 1) {
            return response(['message' => 'error'], 500);
        }
        
        foreach($purchase_order->item as $index => $i) {
            $i->update([
                'item_order' => 'item '.($index + 1)
            ]);
        }
        
        
    }

    public function ajaxUpdate($id, Request $request) {
        $item = Item::find($id);
        $item->update($request->all());
        return $item;
    }
}
