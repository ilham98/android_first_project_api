<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsetKomputer extends Model
{
    protected $table = 'tr_aset_komputer';
    protected $fillable = [
        'aset_id', 
        'processor', 
        'ram', 
        'kapasitas_hardisk', 
        'mainboard', 
        'ethernet',
        'product_key_os',
        'sistem_operasi_id',
        'service_tag',
        'service_code',
        'klasifikasi_aset',
        'catatan'
    ];

    public $timestamps = false;

    public function sistem_operasi() {
        return $this->belongsTo('App\SistemOperasi', 'sistem_operasi_id', 'id');
    }

    public function software() {
        return $this->belongsToMany('App\Software', 'tr_aset_komputer_software', 'aset_komputer_id', 'software_id');
    }

    public function aset() {
        return $this->belongsTo('App\Aset', 'aset_id', 'id');
    }
}
