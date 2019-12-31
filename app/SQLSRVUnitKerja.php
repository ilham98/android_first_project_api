<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRVUnitKerja extends Model
{
    protected $table = 'Ms_UnitKerja';
    protected $connection = 'sqlsrv2';
    public $incrementing = false;
    protected $primaryKey = 'KodeUnitKerja';
    public $timestamps = false;
}
