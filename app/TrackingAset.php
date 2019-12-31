<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingAset extends Model
{
    protected $table = 'tr_tracking_aset';
    protected $fillable = ['aset_id', 'title', 'body'];
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
}
