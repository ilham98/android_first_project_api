<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsetMonitor extends Model
{
    protected $table = 'tr_aset_monitor';

    protected $fillable = ['aset_id', 'lebar', 'merk', 'tipe_monitor_id'];
    public $timestamps = false;

    public function tipe_monitor() {
        return $this->belongsTo('App\TipeMonitor', 'tipe_monitor_id', 'id');
    }

    public function aset() {
        return $this->belongsTo('App\Aset', 'aset_id', 'id');
    }
}
