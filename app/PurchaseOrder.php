<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;
    protected $table = 'tr_purchase_order';
    const UPDATED_AT = 'updated_on';
    const CREATED_AT = 'created_on';
    const DELETED_AT = 'deleted_on';

    protected $fillable = ['date', 'vendor_id', 'created_by', 'updated_by', 'deleted_by', 'po_number'];

    public function vendor() {
        return $this->belongsTo('App\Vendor', 'vendor_id', 'id');
    }

    public function item() {
        return $this->hasMany('App\Item', 'purchase_order_id', 'id');
    }
}
