<?php

namespace App\Http\Controllers\API;

use App\Aset;
use App\AsetKomputer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsetKomputerController extends Controller
{
    public function single($id) {        
        $asetKomputer = AsetKomputer::where('aset_id', $id)->with('software', 'sistem_operasi.jenis_sistem_operasi', 'aset')->first();
        if(!$asetKomputer)
            return response(['message' => 'error'], 500);
        return $asetKomputer;
    }


    public function store(Request $request, $id) { 
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
        $asetKomputer = AsetKomputer::firstOrCreate(
            ['aset_id' => $id],
            $request->all()
        );
        
        $asetKomputer->update($request->all());
        $asetKomputer->software()->sync($request->software_id);

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

    public function softwareIndex($id) {
        $asetKomputer = AsetKomputer::where('aset_id', $id)->with('software', 'sistem_operasi.jenis_sistem_operasi')->first();
        if($asetKomputer)
            return $asetKomputer->software;
        return [];
    }

    public function destroy($id, Request $request) {
        $aset = Aset::find($id);
        if($request->user_role_id == 4 && ($aset->teknisi_npk != $request->user_npk || $aset->kabag_layanan_in_on != null))
            return response('error', 500);
        $aset->update([
            'pic' => null, 
            'catatan' => null, 
            'klasifikasi_aset' => null,
            'kontrol_aset_in_on' => null,
            'kontrol_aset_in_by' => null
        ]);   
        
        $asetKomputer = AsetKomputer::where('aset_id', $id)->first();
        if(!$asetKomputer)
            return response(['message' => 'error'], 500);

        $asetKomputer->delete();
        
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
            $asetKomputer->aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }
}
