<?php

namespace App\Http\Controllers\API;

use App\Aset;
use App\SQLSRVKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SignUploadController extends Controller
{
    public function upload(Request $request, $id) {
        $file = $this->fileHandler($request->file('file'));
        $aset = Aset::find($id);
        if($aset->disposisi_kepada_user_on == null)
            return response('error', 500);
            
        $aset->update([
            'barang_diserahkan_ke_pengguna_on' => \Carbon\Carbon::now(),
            'barang_diserahkan_ke_pengguna_by' => $request->user_npk,
            'signature_url' => url($file['path']),
            'nama_pengambil_barang' => $request->nama
        ]);

        \App\TrackingAset::create([
            'aset_id' => $aset->id,
            'title' => "Barang telah diserahkan kepada user",
            'body' => "Barang telah diserahkan kepada ".$request->nama
        ]);
    
        return $aset;
    }

    public function cancel($id) {
        $aset = Aset::find($id);
        $aset->update([
            'barang_diserahkan_ke_pengguna_on' => null,
            'barang_diserahkan_ke_pengguna_by' => null,
            'signature_url' => null,
            'nama_pengambil_barang' => null
        ]);

        \App\TrackingAset::create([
            'aset_id' => $aset->id,
            'title' => "Penyerahan barang dibatalkan oleh rendal",
            'body' => "Penyerahan barang dibatalkan oleh rendal"
        ]);

        return $aset;
    }

    public function fileHandler($file) {
        $originalName = $file->getClientOriginalName();
        $arrayOfName = explode('.', $originalName);
        $name = uniqid().'.'.$arrayOfName[count($arrayOfName)-1];
        $path = '/signs/'.$name;
        Storage::disk('sign')->putFileAs('', $file, $name);
        return [ 'path' => $path,  'name' => $name];
    }
}
