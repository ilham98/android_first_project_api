<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermintaanPengeluaranBarang extends Model
{
    protected $table = 'tr_permintaan_pengeluaran_barang';
    protected $fillable = ['no_surat', 'departemen_id', 'created_by', 'updated_by'];
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    const DELETED_AT = 'deleted_on';

    public function departemen() {
        return $this->belongsTo('App\SQLSRVDepartemen', 'departemen_id', 'id');
    }
}
