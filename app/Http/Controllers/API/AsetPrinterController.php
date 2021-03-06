<?php

namespace App\Http\Controllers\API;

use App\Aset;
use App\AsetPrinter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsetPrinterController extends Controller
{
    public function store($id, Request $request) {
        $aset = Aset::find($id);
        if($request->user_role_id == 4 && ($aset->teknisi_npk != $request->user_npk || $aset->kabag_layanan_in_on != null))
            return response('error', 500);
        $aset->update([
            'pic' => $request->pic, 
            'catatan' => $request->catatan, 
            'klasifikasi_aset' => $request->klasifikasi_aset,
            'kontrol_aset_in_on' => \Carbon\Carbon::now(),
            'kontrol_aset_in_by' => $request->user_npk
            ]);
        $asetPrinter = AsetPrinter::firstOrCreate(
            ['aset_id' => $id],
            $request->all()
        ); 
        
        $asetPrinter->update($request->all());

        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        $teknisi = \App\User::where('npk', $request->user_npk)->first()->karyawan->nama;

        $title = "Input kontrol selesai";
        $body = "Input kontrol oleh teknisi $teknisi selesai.";

        sendNotification(
            $title, 
            $body, 
            $user_ids, 
            2,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function single($id) {        
        $asetPrinter = AsetPrinter::where('aset_id', $id)->with('aset')->first();
        if(!$asetPrinter)
            return response(['message' => 'error'], 500);
        return $asetPrinter;
    }

    public function destroy($id, Request $request) {
        $aset = Aset::find($id);
        if($request->user_role_id == 4 && ($aset->teknisi_npk != $request->user_npk || $aset->kabag_layanan_in_on != null))
            return response('error', 500);
        $asetPrinter = AsetPrinter::where('aset_id', $id)->first();
        if($asetPrinter)
            $asetPrinter->delete();


        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        $teknisi = \App\User::where('npk', $request->user_npk)->first()->karyawan->nama;
        $title = "Pembatalan Input Aset";
        $body = "Input kontrol oleh teknisi $teknisi dibatalkan.";

        sendNotification(
            $title, 
            $body, 
            $user_ids, 
            0,
            $asetPrinter->aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

}
