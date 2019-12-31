<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsetPrinter extends Model
{
    protected $table = 'tr_aset_printer';
    protected $fillable = ['merk', 'aset_id'];

    public $timestamps = false;

    public function aset() {
        return $this->belongsTo('App\Aset', 'aset_id', 'id');
    }
}
