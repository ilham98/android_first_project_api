<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SistemOperasi extends Model
{
    protected $table = 'vl_sistem_operasi';
    public $timestamps = false;

    public function jenis_sistem_operasi() {
        return $this->belongsTo('App\JenisSistemOperasi', 'jenis_sistem_operasi_id', 'id');
    }
}
