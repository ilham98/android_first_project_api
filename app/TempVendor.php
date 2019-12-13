<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempVendor extends Model
{
    protected $table = 'tmp_vendor';
    protected $fillable = ['nama', 'contact_person'];
    public $timestamps = false;
}
