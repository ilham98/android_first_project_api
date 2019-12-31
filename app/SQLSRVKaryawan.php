<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRVKaryawan extends Model
{
    protected $table = 'v_karyawan_posisi_valid';
    public $incrementing = false;
    protected $primaryKey = 'npk';
    public $timestamps = false;
    protected $connection = 'sqlsrv2';

    public function user() {
        return $this->belongsTo('App\User', 'npk', 'npk');
    }
}
