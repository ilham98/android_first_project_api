<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermintaanPengeluaranBarang extends Model
{
    use SoftDeletes;

    protected $table = 'tr_permintaan_pengeluaran_barang';
    protected $fillable = ['no_surat', 'kode_unit_kerja', 'created_by', 'updated_by', 'deleted_on', 'deleted_by'];
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    const DELETED_AT = 'deleted_on';

    public function departemen() {
        return $this->belongsTo('App\SQLSRVDepartemen', 'departemen_id', 'id');
    }

    public function unit_kerja() {
        return $this->belongsTo('App\SQLSRVUnitKerja', 'kode_unit_kerja', 'KodeUnitKerja');
    }

    public function aset() {
        return $this->hasMany('App\Aset', 'permintaan_pengeluaran_barang_id', 'id');
    }
}
