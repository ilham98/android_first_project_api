<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRVKaryawan extends Model
{
    protected $table = 'development_sqlsrv_karyawan';
    public $incrementing = false;
    protected $primaryKey = 'npk';
    public $timestamps = false;
}
