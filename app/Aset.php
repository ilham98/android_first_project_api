<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tr_aset';
    protected $fillable = [
        'registration_number', 
        'purchase_order_id',  
        'type', 
        'nama', 
        'tipe_id', 
        'status_id',
        'item_id', 
        'peminjaman_start_date', 
        'peminjaman_end_date',
        'npk', 
        'created_by', 
        'updated_by', 
        'deleted_by',
        'no_surat', 
        'permintaan_pengeluaran_barang_in_on', 
        'status_pengeluaran_barang_id', 
        'permintaan_pengeluaran_barang_id',
        'teknisi_npk',
        'pic',
        'klasifikasi_aset',
        'catatan',
        //KASIE LAYANAN,
        'kasie_layanan_in_on',
        'kasie_layanan_in_by',
        //TEKNISI IN
        'teknisi_in_on',
        'teknisi_in_by',
        //KONTROL ASET,
        'kontrol_aset_in_on',
        'kontrol_aset_in_by',
        // KABAG LAYANAN IN
        'kabag_layanan_in_on',
        'kabag_layanan_in_by',
        // APPROVE KABAG LAYANAN,
        'approved_by_kabag_layanan_on',
        'approved_by_kabag_layanan_by',
        'rejected_by_kabag_layanan_on',
        'rejected_by_kabag_layanan_by',
        // DISPOSISI KEPADA USER
        'disposisi_kepada_user_npk',
        'disposisi_kepada_user_on',
        'disposisi_kepada_user_by',
        // APPROVE BY KEPALA UNIT KERJA
        'approved_by_kepala_unit_kerja_on',
        'approved_by_kepala_unit_kerja_by',
        // PENYERAHAN BARANG
        'barang_diserahkan_ke_pengguna_on',
        'barang_diserahkan_ke_pengguna_by',
        'signature_url',
        'nama_pengambil_barang'
    ];

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    const DELETED_AT  = 'deleted_on';
    
    // public function purchase_order() {
    //     return $this->belongsTo('App\PurchaseOrder', 'purchase_order_id', 'id');
    // }

    public function item() {
        return $this->belongsTo('App\Item', 'item_id', 'id');
    }

    public function karyawan() {
        return $this->belongsTo('App\SQLSRVKaryawan', 'npk', 'npk');
    }

    public function status() {
        return $this->belongsTo('App\StatusAset', 'status_id', 'id');
    }

    public function tipe() {
        return $this->belongsTo('App\TipeAset', 'tipe_id', 'id');
    }

    public function status_pengeluaran_barang() {
        return $this->belongsTo('App\StatusPengeluaranBarang', 'status_pengeluaran_barang_id', 'id');
    }

    public function departemen() {
        return $this->belongsTo('App\SQLSRVDepartemen', 'departemen_id', 'id');
    }

    public function permintaan_pengeluaran_barang() {
        return $this->belongsTo('App\PermintaanPengeluaranBarang',  'permintaan_pengeluaran_barang_id', 'id');
    }

    public function aset_komputer() {
        return $this->hasOne('App\AsetKomputer', 'aset_id', 'id');
    }

    public function aset_monitor() {
        return $this->hasOne('App\AsetMonitor', 'aset_id', 'id');
    }

    public function aset_printer() {
        return $this->hasOne('App\AsetPrinter', 'aset_id', 'id');
    }

    public function teknisi(){
        return $this->belongsTo('App\SQLSRVKaryawan', 'teknisi_npk', 'npk');
    }

    public function disposisi_user() {
        return $this->belongsTo('App\SQLSRVKaryawan', 'disposisi_kepada_user_npk', 'npk');
    }
}
