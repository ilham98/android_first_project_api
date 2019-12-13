<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aset;
use App\PurchaseOrder;
use App\TipeAset;
use App\StatusAset;
use App\Item;
use DataTables;
use Illuminate\Support\Facades\DB;

class AsetController extends Controller
{
    public function index() {
        $aset = Aset::all();
        return view('aset.index');
    }

    public function create() {
        $status = StatusAset::all();
        $tipe = TipeAset::all();
        return view('aset.create', compact('status', 'tipe'));
    }

    public function store(Request $request) {
        $item = Item::find($request->item);
        Aset::create([
            'registration_number' => $request->registration_number,
            'status_id' => $request->status,
            'tipe_id' => $request->tipe,
            'npk' => $request->user,
            'item_id' => $request->item_id,
            'item_id' => $request->item
        ]);

        return redirect(url('aset'));
    }

    public function edit($id) {
        $status = StatusAset::all();
        $tipe = TipeAset::all();
        $aset = Aset::find($id);
        $item_id = $aset->item_id;
        $item = DB::select(DB::raw("
            SELECT tr_item.id, 
            tr_item.nama, 
            (stok - (SELECT COUNT(id) FROM tr_aset WHERE item_id = tr_item.id 
            AND tr_aset.registration_number IS NOT NULL)) AS stok 
            FROM tr_item 
            WHERE stok > 0 
                AND 
                tr_item.id = $item_id
        "));

        $item = $item[0];
        
        return view('aset.edit', compact('aset', 'status', 'tipe', 'item'));
    }

    public function update(Request $request) {
        $aset = Aset::find($request->id);
        $aset->update([
            'registration_number' => $request->registration_number,
            'status_id' => $request->status,
            'tipe_id' => $request->tipe,
            'npk' => $request->user,
            'item_id' => $request->item
        ]);

        return redirect(url('aset'));
    }

    

    public function json() {
        $aset = Aset::where('registration_number', '<>', null)->get();
        return DataTables::of($aset)
            ->addColumn('user', function($aset) {
                return $aset->karyawan->nama;
            })
            ->addColumn('departemen', function($aset) {
                return $aset->karyawan->departemen;
            })
            ->addColumn('nama', function($aset) {
                return $aset->item->nama;
            })
            ->addColumn('status', function($aset) {
                return $aset->status->nama;
            })->addColumn('user', function($aset) {
                return $aset->karyawan->nama;
            })->addColumn('vendor_name', function($aset) {
                return $aset->item->purchase_order->vendor->nama;
            })->addColumn('action', function ($aset) {
                return '
                    <a href="/aset/'.$aset->id.'"><i class="pe-7s-pen text-success"></i></span>
                    <span class="btnDelete" data-id='.$aset->id.'><i class="pe-7s-trash  text-danger"></i></span>
                ';
            })->make(true);    
    }   
}