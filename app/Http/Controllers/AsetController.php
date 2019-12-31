<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aset;
use App\PurchaseOrder;
use App\TipeAset;
use App\StatusAset;
use App\Item;
use Auth;
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

        return redirect(url('aset'))->with('store-success', 'Data aset berhasil ditambahkan.');
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

        return redirect(url('aset'))->with(['update-success' => 'Data aset berhasil diupdate.']);
    }

    

    public function json(Request $request) {
        $aset = Aset::where('registration_number', '<>', null)->orderBy('id', 'desc')->get();
        return DataTables::of($aset)
            ->addColumn('departemen', function($aset) {
                return $aset->karyawan ? $aset->karyawan->unit_kerja : '-';
            })
            ->addColumn('created_on', function($aset) {
                return date('d-m-Y', strtotime($aset->created_on));
            })
            ->addColumn('po_number', function($aset) {
                return $aset->item->purchase_order->po_number;
            })
            ->addColumn('nama', function($aset) {
                return $aset->item->nama;
            })
            ->addColumn('status', function($aset) {
                return $aset->status->nama;
            })->addColumn('user', function($aset) {
                return $aset->karyawan ? $aset->karyawan->nama : '-';
            })->addColumn('vendor_name', function($aset) {
                return $aset->item->purchase_order->vendor->nama;
            })->addColumn('action', function ($aset) {
                return '
                    <a href="/aset/'.$aset->id.'"><i class="pe-7s-pen text-success"></i></span></a>
                    <span class="btnDelete" data-registration_number="'.$aset->registration_number.'" data-id='.$aset->id.'><i class="pe-7s-trash  text-danger"></i></span>
                ';
            })->addColumn('status_tracking', function ($aset) {
                if($aset->teknisi_in_on != null && $aset->nama_pengambil_barang == null) {
                    return "In Progress";
                } else if($aset->teknisi_in_on != null && $aset->nama_pengambil_barang != null) {
                    return "Close";
                }

                return "New";
            })->make(true);    
    }   

    public function ajaxIndex(Request $request) {
        $aset = Aset::where('registration_number', 'like', '%'.$request->q.'%')->orderBy('kasie_layanan_in_on', 'desc')->get();
        return $aset;
    }

    public function ajaxDestroy($id) {
        $aset = Aset::find($id);
        if($aset->permintaan_pengeluaran_barang_id)
            return response(['message' => 'error'], 500);
            
        $aset->update([
            'deleted_by' => Auth::user()->npk
        ]);
        $aset->delete();
    }
}