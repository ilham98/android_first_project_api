<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $table = 'ms_vendor';
    protected $fillable = ['nama', 'contact_person', 'no_telepon', 'email', 'deleted_by'];
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    const DELETED_AT = 'deleted_on';

    public function purchase_order() {
        return $this->hasMany('App\PurchaseOrder', 'vendor_id', 'id');
    }
}
