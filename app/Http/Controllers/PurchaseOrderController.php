<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrder;
use App\Vendor;
use App\Item;
use App\Aset;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function index() {
        return view('purchase_order.index');
    }

    public function create() {
        $vendor = Vendor::all();
        return view('purchase_order.create', compact('vendor'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'po_number' => 'required',
            'vendor_id' => 'required',
            'item' => 'required'
        ]);

        $purchase_order_body = array_merge($request->all(), ['created_by' => Auth::user()->npk, 'updated_by' => Auth::user()->npk]);

        $po = PurchaseOrder::create($purchase_order_body);
        $items = json_decode($request->item);
        foreach($items as $index => $i) {
            Item::create([
                'nama' => $i->nama,
                'stok' => $i->stok,
                'item_order' => 'item '.($index + 1),
                'purchase_order_id' => $po->id,
                'created_by' => Auth::user()->npk,
                'updated_by' => Auth::user()->npk
            ]);   
        }

        return redirect(url('purchase-order'));
    }

    public function edit($id) {
        $vendor = Vendor::all();
        $purchase_order = PurchaseOrder::find($id);
        $items = json_encode($purchase_order->item);
        return view('purchase_order.edit', compact('purchase_order', 'vendor', 'items'));
    }

    public function update(Request $request, $id) {

        $po = PurchaseOrder::find($id);
        $po->update($request->all());
        $items = json_decode($request->item);
        foreach($po->item as $i) {
            $i->delete();
        }

        foreach($items as $index => $i) {
            Item::create([
                'nama' => $i->nama,
                'stok' => $i->stok,
                'item_order' => 'item '.$index + 1,
                'purchase_order_id' => $po->id,
                'created_by' => Auth::user()->npk,
                'updated_by' => Auth::user()->npk
            ]);   
        }

        return redirect(url()->previous());
    }

    public function json() {
        $purchase_order = PurchaseOrder::orderBy('id', 'desc')->get();
        return DataTables::of($purchase_order)
            ->addColumn('vendor', function($purchase_order) {
                return $purchase_order->vendor->nama;
            })->addColumn('action', function ($purchase_order) {
                return '
                    <a href="/purchase-order/'.$purchase_order->id.'/edit" data-number='.$purchase_order->number.' ><i class="pe-7s-pen text-success"></i></a>
                    <span class="btnDelete" data-number='.$purchase_order->po_number.' data-id='.$purchase_order->id.'><i class="pe-7s-trash  text-danger"></i></span>
                ';
            })->make(true);    
    }

    public function ajaxIndex(Request $request) {
        $purchase_order = PurchaseOrder::where('po_number', 'like', '%'.$request->q.'%')->get();
        return $purchase_order;
    }

    public function ajaxStore(Request $request) {
        $purchase_order_body = array_merge($request->all(), ['created_by' => Auth::user()->npk, 'updated_by' => Auth::user()->npk]);
        $po = PurchaseOrder::create($purchase_order_body);
        $items = json_decode($request->items);
        foreach($items as $index => $i) {
            Item::create([
                'nama' => $i->nama,
                'stok' => $i->stok,
                'item_order' => 'item '.($index + 1),
                'purchase_order_id' => $po->id,
                'created_by' => Auth::user()->npk,
                'updated_by' => Auth::user()->npk
            ]);   
        }

        return response(['message' => 'success']);
    }

    public function ajaxUpdate($id, Request $request) {
        $purchase_order_body = array_merge($request->all(), ['created_by' => Auth::user()->npk, 'updated_by' => Auth::user()->npk]);
        $po = PurchaseOrder::find($id);
        $po->update($purchase_order_body);

        return response(['message' => 'success']);
    }

    public function ajaxDestroy($id) {
        $purchase_order = PurchaseOrder::find($id);
        $purchase_order->delete();

        return response(['message' => 'success', 200]);
    }
}
