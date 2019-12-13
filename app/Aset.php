<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    //
    protected $table = 'tr_aset';
    protected $fillable = [
        'registration_number', 
        'purchase_order_id',  
        'type', 
        'nama', 
        'tipe_id', 
        'status_id',
        'item_id', 
        'npk', 
        'created_by', 
        'updated_by', 
        'no_surat', 
        'permintaan_pengeluaran_barang_in_on', 
        'status_pengeluaran_barang_id', 
        'permintaan_pengeluaran_barang_id',
        'departemen_id'
    ];

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    
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
}
