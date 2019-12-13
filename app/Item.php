<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tr_item';
    protected $fillable = [
        'nama', 
        'stok', 
        'jumlah_temp', 
        'po_number', 
        'purchase_order_id', 
        'item_order',
        'created_by', 
        'updated_by'
    ];
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    public function purchase_order() {
        return $this->belongsTo('App\PurchaseOrder', 'purchase_order_id', 'id');
    }
}
