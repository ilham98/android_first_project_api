<?php

namespace App\Http\Controllers\API;

use App\SQLSRVKaryawan;
use App\Aset;
use App\TrackingAset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsetController extends Controller
{
    public function __construct(Request $request)
    {
        // $this->karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();
        // $this->karyawan_nama = $this->karyawan->nama;
        
    }


    public function index(Request $request) {
        if($request->user_role_id == 4) {
            $aset = Aset::with('tipe', 'item.purchase_order')->where('teknisi_npk', $request->user_npk)->orderBy('teknisi_in_on', 'desc');
            if($request->q) {
                $aset = $aset->where('registration_number', 'LIKE', '%'.$request->q.'%');
            }
        }    
        else {
            $aset = Aset::with('tipe', 'item.purchase_order')->where('permintaan_pengeluaran_barang_id', '<>', null)->orderBy('id', 'desc');
            if($request->q) {
                $aset = $aset->where('registration_number', 'LIKE', '%'.$request->q.'%');
            }
        }
        return $aset->paginate(20);;
    }

    public function store($id, Request $request) {
        $aset = Aset::find($id);
        $aset->update([
            'teknisi_npk' => $request->teknisi_npk,
            'teknisi_in_on' => \Carbon\Carbon::now(),
            'teknisi_in_by' => $request->user_npk
        ]);
        

        $user = \App\User::where('npk', $request->teknisi_npk)->first();
        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();

        sendNotification(
            "Permintaan Setting Kontrol Aset", 
            "Permintaan Setting Kontrol Aset Oleh ".$karyawan->nama, 
            $user->id,
            3,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function single($id, Request $request) {
        $aset = Aset::with('tipe', 'permintaan_pengeluaran_barang.unit_kerja', 'item.purchase_order', 'status_pengeluaran_barang', 'disposisi_user')->find($id);
        if($request->user_role_id == 4 && $aset->teknisi_npk != $request->user_npk)
            return response('error', 500);
        return $aset;
    }

    public function cancel(Request $request, $id) {
        $aset = Aset::find($id);
        $user = \App\User::where('npk', $aset->teknisi_npk)->first();

        if($aset->kontrol_aset_in_on != null)
            return response('error', 500);

        $aset->update([
            'teknisi_npk' => null,
            'teknisi_in_on' => null,
            'teknisi_in_by' => null
        ]);

        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();

        sendNotification(
            "Pembatalan permintaan Kontrol Aset", 
            "Pembatalan permintaan Kontrol Aset ".$karyawan->nama, 
            $user->id, 
            0,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }
    
    public function asetForTeknisiIndex(Request $request) {
        return Aset::with('tipe', 'item.purchase_order')->where('teknisi_npk', $request->user_npk)->orderBy('teknisi_in_on', 'desc')->paginate(20);
    }

    public function as($id, Request $request) {
       $aset = Aset::find($id);
       $aset->update(['teknisi_npk' => $request->teknisi_npk]);

    }

    public function disposisiKabagLayanan($id, Request $request) {
        $aset = Aset::find($id);
        
        if($aset->kontrol_aset_in_on == null || $aset->approved_by_kabag_layanan_on != null || $aset->rejected_by_kabag_layanan_on != null) {
            return response('error', 500);
        }
        $aset->update([
            'kabag_layanan_in_on' => \Carbon\Carbon::now(),
            'kabag_layanan_in_by' => $request->user_npk
        ]);

        $user_ids = \App\User::where('role_id', 5)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();

        sendNotification(
            "Disposisi Barang Dari Kasie Layanan", 
            "Disposisi Barang Oleh Kasie Layanan ".$karyawan->nama, 
            $user_ids, 
            4,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function disposisiKabagLayananCancel(Request $request, $id) {
        $aset = Aset::find($id);
        if($aset->kontrol_aset_in_on == null || $aset->approved_by_kabag_layanan_on != null || $aset->rejected_by_kabag_layanan_on != null) {
            return response('error', 500);
        }
        $aset->update([
            'kabag_layanan_in_on' => null,
            'kabag_layanan_in_by' => null
        ]);

        $user_ids = \App\User::where('role_id', 5)->get()->map(function($u) {
            return $u->id;
        })->toArray();
        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();
        sendNotification(
            "Disposisi Barang Dari Kasie Layanan Dibatalkan", 
            "Disposisi Barang Dibatalkan Oleh Kasie Layanan ".$karyawan->nama, 
            $user_ids, 
            4,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function approveKabagLayanan(Request $request, $id) {
        $aset = Aset::find($id);
        if($aset->kabag_layanan_in_on == null || $aset->approved_by_kepala_unit_kerja_on != null)
            return response('error', 500);
        $aset->update([
            'approved_by_kabag_layanan_on' => \Carbon\Carbon::now(),
            'approved_by_kabag_layanan_by' => $request->user_npk
        ]);

        $user_ids = \App\User::where('role_id', 6)->get()->map(function($u) {
            return $u->id;
        })->toArray();
        
        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();

        sendNotification(
            "Kabag Layanan Mengkonfirmasi Permintaan Pengeluaran Barang", 
            "Kabag Layanan ".$karyawan->nama." Kabag Layanan Mengkonfirmasi Permintaan Pengeluaran Barang", 
            $user_ids, 
            5,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function rejectKabagLayanan(Request $request, $id) {
        $aset = Aset::find($id);
        if($aset->kabag_layanan_in_on == null || $aset->approved_by_kepala_unit_kerja_on != null)
            return response('error', 500);
        $aset->update([
            'rejected_by_kabag_layanan_on' => \Carbon\Carbon::now(),
            'rejected_by_kabag_layanan_by' => $request->user_npk
        ]);
        
        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();

        sendNotification(
            "Kabag Layanan Menolak Permintaan Pengeluaran Barang", 
            "Kabag Layanan ".$karyawan->nama." Kabag Layanan Menolak Permintaan Pengeluaran Barang", 
            $user_ids, 
            0,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function kabagLayananCancel(Request $request, $id) {
        $aset = Aset::find($id);
        if($aset->kabag_layanan_in_on == null || $aset->approved_by_kepala_unit_kerja_on != null)
            return response('error', 500);
        $aset->update([
            'approved_by_kabag_layanan_on' => null,
            'approved_by_kabag_layanan_by' => null,
            'rejected_by_kabag_layanan_on' => null,
            'rejected_by_kabag_layanan_by' => null
        ]);

        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();
        
        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();
        sendNotification(
            "Kabag Layanan Membatalkan Permintaan Pengeluaran Barang", 
            "Kabag Layanan ".$karyawan->nama." Kabag Layanan Membatalkan Permintaan Pengeluaran Barang", 
            $user_ids, 
            0,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function massActionKabagLayanan(Request $request) {
        $now = \Carbon\Carbon::now();
        $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
            return $u->id;
        })->toArray();
        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first();
        $aset = Aset::whereIn('id', $request->aset_ids);

        if($request->action == 1) {    
            $aset->update([
                'approved_by_kabag_layanan_on' => $now,
                'approved_by_kabag_layanan_by' => $request->user_npk,
                'rejected_by_kabag_layanan_on' => null,
                'rejected_by_kabag_layanan_by' => null
            ]);

            sendNotification(
                "Kabag Layanan Mengkonfirmasi Permintaan Pengeluaran Barang", 
                "Kabag Layanan ".$karyawan->nama." Kabag Layanan Mengkonfirmasi Permintaan Pengeluaran Barang", 
                $user_ids, 
                8,
                $aset->pluck('id'),
                ['data' => ['message' => 'success'], 'status' => 200]
            );
        } else if($request->action == 2) {
            $aset->update([
                'rejected_by_kabag_layanan_on' => $now,
                'rejected_by_kabag_layanan_by' => $request->user_npk,
                'approved_by_kabag_layanan_on' => null,
                'approved_by_kabag_layanan_by' => null
            ]);
            sendNotification(
                "Kabag Layanan Menolak Permintaan Pengeluaran Barang", 
                "Kabag Layanan ".$karyawan->nama." Kabag Layanan Menolak Permintaan Pengeluaran Barang", 
                $user_ids, 
                8,
                $aset->pluck('id'),
                ['data' => ['message' => 'success'], 'status' => 200]
            );
        } else {
            $aset->update([
                'approved_by_kabag_layanan_on' => null,
                'approved_by_kabag_layanan_by' => null,
                'rejected_by_kabag_layanan_on' => null,
                'rejected_by_kabag_layanan_by' => null
            ]);
            sendNotification(
                "Kabag Layanan Membatalkan Permintaan Pengeluaran Barang", 
                "Kabag Layanan ".$karyawan->nama." Kabag Layanan Membatalkan Permintaan Pengeluaran Barang", 
                $user_ids, 
                8,
                $aset->pluck('id'),
                ['data' => ['message' => 'success'], 'status' => 200]
            );
        }
    }

    public function approveKepalaUnitKerja(Request $request, $id) {
        $aset = Aset::find($id);
        if($aset->approved_by_kabag_layanan_on == null || $aset->barang_diserahkan_ke_pengguna_on != null)
            return response('error', 500);
        $aset->update([
            'approved_by_kepala_unit_kerja_on' => \Carbon\Carbon::now(),
            'approved_by_kepala_unit_kerja_by' => $request->user_npk
        ]);

        $user_ids = \App\User::where('role_id', 2)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        return response(['message' => 'success'], 200);
    }

    public function approveKepalaUnitKerjaCancel(Request $request, $id) {
        $aset = Aset::find($id);
        if($aset->approved_by_kabag_layanan_on == null || $aset->barang_diserahkan_ke_pengguna_on != null)
            return response('error', 500);
       
        $aset->update([
            'approved_by_kepala_unit_kerja_on' => null,
            'approved_by_kepala_unit_kerja_by' => null
        ]);

        $user_ids = \App\User::where('role_id', 2)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        return response(['message' => 'success'], 200);
    }

    public function disposisiUser($id, Request $request) {
        $aset = Aset::find($id);
        // if($aset->approved_by_kabag_layanan_on == null || $aset->barang_diserahkan_ke_pengguna_on != null)
        //     return response('error', 500);
        
        $aset->update([
            'disposisi_kepada_user_npk' => $request->npk,
            'disposisi_kepada_user_on' => \Carbon\Carbon::now(),
            'disposisi_kepada_user_by' => $request->user_npk
        ]);

        $user_ids = \App\User::where('role_id', 2)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first()->nama;
        $karyawan_disposisi = SQLSRVKaryawan::where('npk', $request->npk)->first()->nama;
        sendNotification(
            "Kepala Unit Kerja Menyetujui Syarat Dan Ketentuan", 
            "Kepala Unit Kerja $karyawan Menyetujui Syarat Dan Ketentuan, dan mendisposisi barang kepada $karyawan_disposisi", 
            $user_ids, 
            6,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function disposisiUserCancel($id, Request $request) {
        $aset = Aset::find($id);
        if($aset->approved_by_kabag_layanan_on == null || $aset->barang_diserahkan_ke_pengguna_on != null)
            return response('error', 500);
       
        $aset->update([
            'disposisi_kepada_user_npk' => null,
            'disposisi_kepada_user_on' => null,
            'disposisi_kepada_user_by' => null
        ]);

        $karyawan = SQLSRVKaryawan::where('npk', $request->user_npk)->first()->nama;

        $user_ids = \App\User::where('role_id', 2)->get()->map(function($u) {
            return $u->id;
        })->toArray();

        sendNotification(
            "Kepala Unit Kerja Membatalkan Disposisi", 
            "Kepala Unit Kerja $karyawan Membatalkan disposisi.", 
            $user_ids, 
            6,
            $aset->id,
            ['data' => ['message' => 'success'], 'status' => 200]
        );
    }

    public function tracking($id) {
        $tracking_aset = TrackingAset::where('aset_id', $id)->orderBy('created_on', 'desc')->get();
        if(count($tracking_aset) == 0) 
            return response('error', 500);
        return $tracking_aset;
    }
}
