<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'ms_vendor';
    protected $fillable = ['nama', 'contact_person'];
    const CREATED_AT = 'createdOn';
    const UPDATED_AT = 'updatedOn';
}
